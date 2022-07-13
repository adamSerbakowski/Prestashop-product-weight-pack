// Replace original class getTotalWeight() in Cart.php class 

public function getTotalWeight($products = null)
    {
        if (null !== $products) {
            $total_weight = 0;
            foreach ($products as $product) {
               // Getting info from database about max number of products in one package - bb_pack is an additional column in product table in which data is stored
               $bb_pack = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('SELECT `bb_pack` FROM ' . _DB_PREFIX_ . 'product WHERE `id_product` = ' . $product['id_product']);
                if (!isset($product['weight_attribute']) || null === $product['weight_attribute']) {
                    
                    $total_weight += $product['weight'] * ceil($product['cart_quantity'] / $bb_pack);
                } else {
                    $total_weight += $product['weight_attribute'] * ceil($product['cart_quantity'] / $bb_pack);
                }
            }

            return $total_weight;
        }

        if (!isset(self::$_totalWeight[$this->id])) {
            $this->updateProductWeight($this->id);
        }

        return self::$_totalWeight[(int) $this->id];
    }
