<?php

namespace App\Controllers;

use App\Models\DonationModel;
use App\Models\CampaignModel;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends BaseController
{
    protected DonationModel $donationModel;
    protected CampaignModel $campaignModel;

    public function __construct()
    {
        $this->donationModel = new DonationModel();
        $this->campaignModel = new CampaignModel();

        $config = config('Midtrans');

        Config::$serverKey    = $config->serverKey;
        Config::$clientKey    = $config->clientKey;
        Config::$isProduction = $config->isProduction;
        Config::$isSanitized  = $config->isSanitized;
        Config::$is3ds        = $config->is3ds;
    }

    public function checkout($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'donatur') {
            return redirect()->to('/login')->with('error', 'Silakan login sebagai donatur terlebih dahulu.');
        }

        $donation = $this->donationModel
            ->where('id', (int) $id)
            ->where('user_id', (int) session()->get('id'))
            ->first();

        if (!$donation) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $campaign = $this->campaignModel->find($donation['campaign_id']);

        if (!$campaign) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (!empty($donation['snap_token'])) {
            $snapToken = $donation['snap_token'];
        } else {
            $params = [
                'transaction_details' => [
                    'order_id'     => $donation['invoice'],
                    'gross_amount' => (int) $donation['nominal'],
                ],
                'customer_details' => [
                    'first_name' => session()->get('nama') ?: 'Donatur',
                    'email'      => session()->get('email') ?: 'donatur@example.com',
                ],
                'item_details' => [[
                    'id'       => (string) $campaign['id'],
                    'price'    => (int) $donation['nominal'],
                    'quantity' => 1,
                    'name'     => mb_substr($campaign['judul'], 0, 50),
                ]],
            ];

            $snapToken = Snap::getSnapToken($params);

            $this->donationModel->update($id, [
                'snap_token' => $snapToken,
                'gross_amount' => (int) $donation['nominal'],
                'metode_pembayaran' => 'midtrans',
            ]);
        }

        return view('payment/checkout', [
            'title'     => 'Pembayaran Donasi | DonasiKu',
            'snapToken' => $snapToken,
            'donation'  => $donation,
            'campaign'  => $campaign,
        ]);
    }

    public function notification()
    {
        $notification = new Notification();

        $transaction = $notification->transaction_status ?? null;
        $fraud       = $notification->fraud_status ?? null;
        $orderId     = $notification->order_id ?? null;

        $donation = $this->donationModel
            ->where('invoice', $orderId)
            ->first();

        if (!$donation) {
            return $this->response->setStatusCode(404)->setJSON(['status' => 'NOT_FOUND']);
        }

        $oldStatus = strtolower((string) ($donation['status'] ?? 'pending'));
        $wasAlreadySuccess = in_array($oldStatus, ['berhasil', 'verified', 'success', 'paid'], true)
            || in_array(strtolower((string) ($donation['transaction_status'] ?? '')), ['settlement', 'capture'], true);

        $update = [
            'transaction_id'     => $notification->transaction_id ?? null,
            'payment_type'       => $notification->payment_type ?? null,
            'transaction_status' => $transaction,
            'fraud_status'       => $fraud,
            'gross_amount'       => $notification->gross_amount ?? $donation['nominal'],
        ];

        if (isset($notification->va_numbers[0])) {
            $update['bank']      = $notification->va_numbers[0]->bank ?? null;
            $update['va_number'] = $notification->va_numbers[0]->va_number ?? null;
        }

        $isSuccess = (($transaction === 'capture' && ($fraud === 'accept' || $fraud === null)) || $transaction === 'settlement');

        $db = db_connect();
        $db->transStart();

        if ($isSuccess) {
            $update['status']  = 'berhasil';
            $update['paid_at'] = date('Y-m-d H:i:s');

            if (!$wasAlreadySuccess) {
                $campaign = $this->campaignModel->find($donation['campaign_id']);

                if ($campaign) {
                    $this->campaignModel->update($campaign['id'], [
                        'dana_terkumpul' => (float) ($campaign['dana_terkumpul'] ?? 0) + (float) ($donation['nominal'] ?? 0),
                        'jumlah_donatur' => (int) ($campaign['jumlah_donatur'] ?? 0) + 1,
                    ]);
                }
            }
        } elseif ($transaction === 'pending') {
            $update['status'] = 'pending';
        } elseif (in_array($transaction, ['expire', 'expired'], true)) {
            $update['status'] = 'expired';
        } elseif (in_array($transaction, ['cancel', 'deny'], true)) {
            $update['status'] = 'dibatalkan';
        }

        $this->donationModel->update($donation['id'], $update);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setStatusCode(500)->setJSON(['status' => 'FAILED']);
        }

        return $this->response->setJSON(['status' => 'OK']);
    }
}
