<?php

namespace App\Models;

use CodeIgniter\Model;

class CampaignImageModel extends Model
{
    protected $table = 'campaign_images';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'campaign_id',
        'image',
        'is_cover',
        'sort_order'
    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';

    /*
    |--------------------------------------------------------------------------
    | Semua gambar campaign
    |--------------------------------------------------------------------------
    */

    public function getImages($campaignId)
    {
        return $this->where('campaign_id', $campaignId)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    /*
    |--------------------------------------------------------------------------
    | Cover campaign
    |--------------------------------------------------------------------------
    */

    public function getCover($campaignId)
    {
        $cover = $this->where('campaign_id', $campaignId)
                      ->where('is_cover', 1)
                      ->first();

        if ($cover) {
            return $cover;
        }

        return $this->where('campaign_id', $campaignId)
                    ->first();
    }

    /*
    |--------------------------------------------------------------------------
    | Hapus semua gambar campaign
    |--------------------------------------------------------------------------
    */

    public function deleteByCampaign($campaignId)
    {
        $images = $this->where('campaign_id', $campaignId)->findAll();

        foreach ($images as $img) {

            $path = FCPATH . 'uploads/campaign/' . $img['image'];

            if (is_file($path)) {
                unlink($path);
            }
        }

        return $this->where('campaign_id', $campaignId)->delete();
    }
}