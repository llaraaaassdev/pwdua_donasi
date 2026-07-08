<?php

namespace App\Models;

use CodeIgniter\Model;

class DonationModel extends Model
{
    protected $table = 'donations';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'campaign_id',
        'user_id',
        'invoice',
        'snap_token',
        'transaction_id',
        'payment_type',
        'bank',
        'va_number',
        'gross_amount',
        'transaction_status',
        'fraud_status',
        'paid_at',
        'nominal',
        'metode_pembayaran',
        'bukti_pembayaran',
        'pesan',
        'anonim',
        'status',
        'tanggal_donasi',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function baseDonationSelect()
    {
        return $this->select('
                donations.*,
                users.nama AS donor_nama,
                users.email AS donor_email,
                users.no_hp AS donor_no_hp,
                campaigns.judul,
                campaigns.gambar AS campaign_gambar,
                campaigns.foundation_id,
                foundations.nama_yayasan,
                foundations.user_id AS foundation_user_id,
                categories.nama_kategori
            ')
            ->join('users', 'users.id = donations.user_id', 'left')
            ->join('campaigns', 'campaigns.id = donations.campaign_id', 'left')
            ->join('foundations', 'foundations.id = campaigns.foundation_id', 'left')
            ->join('categories', 'categories.id = campaigns.category_id', 'left');
    }

    public function getDonations()
    {
        return $this->baseDonationSelect()
            ->orderBy('donations.created_at', 'DESC')
            ->findAll();
    }

    public function getDonationDetail($id)
    {
        return $this->baseDonationSelect()
            ->where('donations.id', $id)
            ->first();
    }

    private function applyAdminFilters($keyword = null, $status = null, $paymentType = null)
    {
        $builder = $this->baseDonationSelect();

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('donations.invoice', $keyword)
                ->orLike('donations.transaction_id', $keyword)
                ->orLike('campaigns.judul', $keyword)
                ->orLike('foundations.nama_yayasan', $keyword)
                ->groupEnd();
        }

        if (!empty($status)) {
            if ($status === 'berhasil') {
                $builder->groupStart()
                    ->whereIn('donations.status', ['berhasil', 'verified', 'success', 'paid'])
                    ->orWhereIn('donations.transaction_status', ['settlement', 'capture'])
                    ->groupEnd();
            } elseif ($status === 'ditolak') {
                $builder->groupStart()
                    ->whereIn('donations.status', ['ditolak', 'rejected'])
                    ->orWhere('donations.transaction_status', 'deny')
                    ->groupEnd();
            } elseif ($status === 'expired') {
                $builder->groupStart()
                    ->where('donations.status', 'expired')
                    ->orWhereIn('donations.transaction_status', ['expire', 'expired'])
                    ->groupEnd();
            } elseif ($status === 'dibatalkan') {
                $builder->groupStart()
                    ->whereIn('donations.status', ['dibatalkan', 'cancel', 'cancelled'])
                    ->orWhere('donations.transaction_status', 'cancel')
                    ->groupEnd();
            } else {
                $builder->where('donations.status', $status);
            }
        }

        if (!empty($paymentType)) {
            $builder->groupStart()
                ->where('donations.payment_type', $paymentType)
                ->orWhere('donations.metode_pembayaran', $paymentType)
                ->groupEnd();
        }

        return $builder;
    }

    public function filterDonation($keyword = null, $status = null, $paymentType = null)
    {
        return $this->applyAdminFilters($keyword, $status, $paymentType)
            ->orderBy('donations.created_at', 'DESC')
            ->findAll();
    }

    public function filterDonationPaginated($keyword = null, $status = null, $paymentTypeOrPerPage = null, $perPage = 25)
    {
        $paymentType = null;

        if (is_numeric($paymentTypeOrPerPage) && (int) $paymentTypeOrPerPage > 0 && $perPage === 25) {
            $perPage = (int) $paymentTypeOrPerPage;
        } else {
            $paymentType = $paymentTypeOrPerPage;
            $perPage = (int) $perPage;
        }

        return $this->applyAdminFilters($keyword, $status, $paymentType)
            ->orderBy('donations.created_at', 'DESC')
            ->paginate($perPage, 'donations');
    }

    public function getPaymentTypes()
    {
        return $this->select('COALESCE(NULLIF(payment_type, \'\'), NULLIF(metode_pembayaran, \'\')) AS payment_type', false)
            ->groupStart()
                ->where('payment_type IS NOT NULL', null, false)
                ->where('payment_type !=', '')
            ->groupEnd()
            ->orGroupStart()
                ->where('metode_pembayaran IS NOT NULL', null, false)
                ->where('metode_pembayaran !=', '')
            ->groupEnd()
            ->groupBy('COALESCE(NULLIF(payment_type, \'\'), NULLIF(metode_pembayaran, \'\'))')
            ->orderBy('payment_type', 'ASC')
            ->findAll();
    }

    public function getDashboardStats()
    {
        $db = db_connect();

        $totalDonasi = (int) $db->table($this->table)->countAllResults();

        $nominalBerhasil = (float) ($db->table($this->table)
            ->selectSum('nominal', 'total')
            ->groupStart()
                ->whereIn('status', ['berhasil', 'verified', 'success', 'paid'])
                ->orWhereIn('transaction_status', ['settlement', 'capture'])
            ->groupEnd()
            ->get()
            ->getRowArray()['total'] ?? 0);

        $pending = (int) $db->table($this->table)
            ->groupStart()
                ->where('status', 'pending')
                ->orWhere('transaction_status', 'pending')
            ->groupEnd()
            ->countAllResults();

        $berhasil = (int) $db->table($this->table)
            ->groupStart()
                ->whereIn('status', ['berhasil', 'verified', 'success', 'paid'])
                ->orWhereIn('transaction_status', ['settlement', 'capture'])
            ->groupEnd()
            ->countAllResults();

        $expired = (int) $db->table($this->table)
            ->groupStart()
                ->where('status', 'expired')
                ->orWhereIn('transaction_status', ['expire', 'expired'])
            ->groupEnd()
            ->countAllResults();

        $dibatalkan = (int) $db->table($this->table)
            ->groupStart()
                ->whereIn('status', ['dibatalkan', 'cancel', 'cancelled'])
                ->orWhere('transaction_status', 'cancel')
            ->groupEnd()
            ->countAllResults();

        $anonim = (int) $db->table($this->table)->where('anonim', 1)->countAllResults();

        return [
            'total_donasi'     => $totalDonasi,
            'nominal_berhasil' => $nominalBerhasil,
            'pending'          => $pending,
            'berhasil'         => $berhasil,
            'expired'          => $expired,
            'dibatalkan'       => $dibatalkan,
            'anonim'           => $anonim,
        ];
    }

    public function getDonorHistory($userId, $perPage = 10)
    {
        return $this->baseDonationSelect()
            ->where('donations.user_id', $userId)
            ->orderBy('donations.created_at', 'DESC')
            ->paginate($perPage, 'donor_history');
    }

    public function getDonorDonationDetail($id, $userId)
    {
        return $this->baseDonationSelect()
            ->where('donations.id', $id)
            ->where('donations.user_id', $userId)
            ->first();
    }

    public function getDonorStats($userId)
    {
        $db = db_connect();

        $row = $db->table($this->table)
            ->select("COUNT(id) AS total_transaksi, COALESCE(SUM(CASE WHEN status IN ('berhasil','verified','success','paid') OR transaction_status IN ('settlement','capture') THEN nominal ELSE 0 END), 0) AS total_berhasil", false)
            ->where('user_id', $userId)
            ->get()
            ->getRowArray();

        return [
            'total_transaksi' => (int) ($row['total_transaksi'] ?? 0),
            'total_berhasil'  => (float) ($row['total_berhasil'] ?? 0),
        ];
    }

    public function getPublicDonationNews($limit = 12)
    {
        return $this->baseDonationSelect()
            ->groupStart()
                ->whereIn('donations.status', ['berhasil', 'verified', 'success', 'paid'])
                ->orWhereIn('donations.transaction_status', ['settlement', 'capture'])
            ->groupEnd()
            ->orderBy('COALESCE(donations.paid_at, donations.created_at)', 'DESC', false)
            ->limit($limit)
            ->findAll();
    }

    public function getPublicDonationNewsPaginated($perPage = 20)
    {
        return $this->baseDonationSelect()
            ->groupStart()
                ->whereIn('donations.status', ['berhasil', 'verified', 'success', 'paid'])
                ->orWhereIn('donations.transaction_status', ['settlement', 'capture'])
            ->groupEnd()
            ->orderBy('COALESCE(donations.paid_at, donations.created_at)', 'DESC', false)
            ->paginate($perPage, 'donation_news');
    }
}
