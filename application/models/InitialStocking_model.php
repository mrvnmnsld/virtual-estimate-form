<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InitialStocking_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get branch details by ID
     */
    public function getBranchById($branchId)
    {
        $this->db->select('branch_id, branch_name, branch_code, contact_number, email, address, region, province, city, barangay');
        $this->db->from('branch_tbl');
        $this->db->where('branch_id', $branchId);
        $this->db->where('is_active', 1);
        return $this->db->get()->row();
    }

    /**
     * Get item details by ID
     */
    public function getItemById($itemId)
    {
        $this->db->select('*');
        $this->db->from('item_tbl');
        $this->db->where('item_id', $itemId);
        $this->db->where('is_active', 1);
        return $this->db->get()->row();
    }

    /**
     * Check if branch already has initial stocking
     */
    public function hasInitialStocking($branchId)
    {
        $this->db->select('COUNT(*) as count');
        $this->db->from('branch_item_stocks');
        $this->db->where('branch_id', $branchId);
        $this->db->like('batch_code', 'INITIAL-');
        $result = $this->db->get()->row();
        return $result->count > 0;
    }

    /**
     * Get initial stocking history for a branch
     */
    public function getInitialStockingHistory($branchId)
    {
        $this->db->select('
            bis.batch_code,
            bis.inventory_code,
            bis.created_at,
            it.item_name,
            bis.initial_stock,
            bis.unit_cost,
            bis.selling_price,
            bis.consumer_price,
            bis.size,
            bis.expiration_date
        ');
        $this->db->from('branch_item_stocks bis');
        $this->db->join('item_tbl it', 'it.item_id = bis.item_id');
        $this->db->where('bis.branch_id', $branchId);
        $this->db->like('bis.batch_code', 'INITIAL-');
        $this->db->order_by('bis.created_at', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Get initial stocking summary
     */
    public function getInitialStockingSummary()
    {
        $this->db->select('
            bt.branch_name,
            bt.branch_code,
            COUNT(DISTINCT bis.batch_code) as total_batches,
            COUNT(bis.branch_item_stocks_id) as total_items,
            SUM(bis.initial_stock) as total_quantity,
            SUM(bis.initial_stock * bis.unit_cost) as total_value,
            MAX(bis.created_at) as last_stocking_date
        ');
        $this->db->from('branch_item_stocks bis');
        $this->db->join('branch_tbl bt', 'bt.branch_id = bis.branch_id');
        $this->db->like('bis.batch_code', 'INITIAL-');
        $this->db->group_by('bis.branch_id, bt.branch_name, bt.branch_code');
        $this->db->order_by('last_stocking_date', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Validate initial stocking data
     */
    public function validateInitialStockingData($items)
    {
        $errors = [];

        foreach ($items as $index => $item) {
            $itemIndex = $index + 1;

            // Validate required fields
            if (empty($item['item_id'])) {
                $errors[] = "Item #{$itemIndex}: Item ID is required";
            }

            if (empty($item['quantity']) || $item['quantity'] <= 0) {
                $errors[] = "Item #{$itemIndex}: Quantity must be greater than 0";
            }

            if (empty($item['unit_cost']) || $item['unit_cost'] < 0) {
                $errors[] = "Item #{$itemIndex}: Unit cost must be 0 or greater";
            }

            if (empty($item['size'])) {
                $errors[] = "Item #{$itemIndex}: Size is required";
            }

            // Validate item exists
            if (!empty($item['item_id'])) {
                $itemExists = $this->getItemById($item['item_id']);
                if (!$itemExists) {
                    $errors[] = "Item #{$itemIndex}: Item not found";
                }
            }

            // Validate percentage pricing if provided
            if (isset($item['percentage_pricing']) && is_array($item['percentage_pricing'])) {
                foreach ($item['percentage_pricing'] as $pricingIndex => $pricing) {
                    $pricingItemIndex = $itemIndex . '.' . ($pricingIndex + 1);
                    
                    if (empty($pricing['percentage']) || $pricing['percentage'] <= 0) {
                        $errors[] = "Item #{$itemIndex} Pricing #{$pricingItemIndex}: Percentage must be greater than 0";
                    }

                    if (isset($pricing['price']) && $pricing['price'] < 0) {
                        $errors[] = "Item #{$itemIndex} Pricing #{$pricingItemIndex}: Price cannot be negative";
                    }
                }
            }
        }

        return $errors;
    }

    /**
     * Generate batch code for branch
     */
    public function generateBatchCode($branchName, $branchCode = null)
    {
        $code = $branchCode ?: strtoupper(substr($branchName, 0, 3));
        $code = strtoupper(str_replace(' ', '', $code));
        return 'INITIAL-' . $code;
    }

    /**
     * Check if batch code already exists
     */
    public function batchCodeExists($batchCode)
    {
        $this->db->select('COUNT(*) as count');
        $this->db->from('branch_item_stocks');
        $this->db->where('batch_code', $batchCode);
        $result = $this->db->get()->row();
        return $result->count > 0;
    }

    /**
     * Get available items for initial stocking
     */
    public function getAvailableItems($searchTerm = '')
    {
        $this->db->select('item_id, item_name, item_code, whole_unit');
        $this->db->from('item_tbl');
        
        if (!empty($searchTerm)) {
            $this->db->group_start();
            $this->db->like('item_name', $searchTerm);
            $this->db->or_like('item_code', $searchTerm);
            $this->db->group_end();
        }
        
        $this->db->order_by('item_name', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Get initial stocking statistics
     */
    public function getInitialStockingStats()
    {
        $stats = [];

        // Total branches with initial stocking
        $this->db->select('COUNT(DISTINCT branch_id) as total_branches');
        $this->db->from('branch_item_stocks');
        $this->db->like('batch_code', 'INITIAL-');
        $result = $this->db->get()->row();
        $stats['total_branches'] = $result->total_branches;

        // Total items stocked
        $this->db->select('COUNT(*) as total_items');
        $this->db->from('branch_item_stocks');
        $this->db->like('batch_code', 'INITIAL-');
        $result = $this->db->get()->row();
        $stats['total_items'] = $result->total_items;

        // Total quantity stocked
        $this->db->select('SUM(initial_stock) as total_quantity');
        $this->db->from('branch_item_stocks');
        $this->db->like('batch_code', 'INITIAL-');
        $result = $this->db->get()->row();
        $stats['total_quantity'] = $result->total_quantity ?: 0;

        // Total value stocked
        $this->db->select('SUM(initial_stock * unit_cost) as total_value');
        $this->db->from('branch_item_stocks');
        $this->db->like('batch_code', 'INITIAL-');
        $result = $this->db->get()->row();
        $stats['total_value'] = $result->total_value ?: 0;

        return $stats;
    }
}
