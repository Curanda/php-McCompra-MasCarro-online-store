<?php
require_once 'db_connection.php';
session_start();

function getCategories() {
    global $conn;
    $result = $conn->query("SELECT * FROM categories");
    if (!$result) {
        die("Query failed: " . $conn->error);
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getSelectedCategory() {
    $default = 'Quantum Harmonizers';
    $selected = isset($_GET['category']) ? $_GET['category'] : $default;
    $_SESSION['selectedCategory'] = $selected;
    return $selected;
}

function renderCategoryItem($category, $isActive) {
    return "<li class='{$isActive}'><a href='?category=" . 
           urlencode($category['category']) . "'>{$category['category']}</a></li>";
}

function displayCategories() {
    $categories = getCategories();
    $selectedCategory = getSelectedCategory();
    
    $output = '';
    if (!empty($categories)) {
        foreach ($categories as $category) {
            $isActive = ($category['category'] === $selectedCategory) ? 'bg-yellow-100' : '';
            $output .= renderCategoryItem($category, $isActive);
        }
    }
    
    return $output;
}

function getSubcategories($category) {
    global $conn;
    $result = $conn->query("SELECT * FROM subcategories WHERE category = '" . 
        $conn->real_escape_string($category) . "'");
    if (!$result) {
        die("Query failed: " . $conn->error);
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

function displaySubcategories() {
    $selectedCategory = getSelectedCategory();
    $subcategories = getSubcategories($selectedCategory);
    
    if (!empty($subcategories)) {
        $output = "<div class='flex justify-start items-start flex-col'>
                    <h1 class='text-lg font-semibold text-[#346734]'>" . htmlspecialchars($selectedCategory) . "</h1>
                    <h3 class='text-xs font-semibold text-gray-500 mb-2'>Harmonizers</h3>
                    <div class='flex justify-start items-start gap-3 flex-row *:flex-col *:text-center *:text-[0.65rem] *:text-gray-500 *:text-wrap [&>div>a>img]:border-1 [&>div>a>img]:border-gray-200 [&>div>a>img]:w-[4rem] [&>div>a>img]:h-[4rem] [&>div>p]:text-wrap [&>div>p]:w-[4rem]'>";
        
        foreach($subcategories as $subcategory) {
            $output .= renderSubcategoryItem($subcategory);
        }
        
        $output .= "</div></div>";
        return $output;
    }
    return "<p>No subcategories found for " . htmlspecialchars($selectedCategory) . "</p>";
}


function getProducts($subcategory) {
    global $conn;
    $result = $conn->query("SELECT * FROM products WHERE subcategory = '" . 
        $conn->real_escape_string($subcategory) . "'");
    if (!$result) {
        die("Query failed: " . $conn->error);
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

function displayProducts() {
    $selectedSubcategory = isset($_GET['subcategory']) ? $_GET['subcategory'] : '';
    $selectedCategory = getSelectedCategory();
    $products = getProducts($selectedSubcategory);
    
    $output = '<h1 class="text-lg font-semibold text-[#346734]">' . htmlspecialchars($selectedCategory) . '</h1>';
    $output .= '<hr class="border-[#346734] w-full" />';
    $output .= '<div class="flex justify-start items-start flex-col">';
    $output .= '<header class="text-sm font-regular mb-1 text-gray-500">' . htmlspecialchars($selectedSubcategory) . '</header>';
    $output .= '</div>';
    $output .= '<hr class="w-full" />';
    
    if (!empty($products)) {
        $output .= "<div class='flex flex-row justify-start items-start my-3 gap-3 [&>*]:border-1 [&>*]:border-gray-300 [&>*]:rounded-xs [&>*]:w-[25rem] [&>*>div]:flex [&>*>div]:flex-row [&>*>div]:justify-start [&>*>div]:items-center [&>*>div]:p-3 [&>*>div]:gap-3 [&>*>div>div]:flex [&>*>div>div]:flex-col [&>*>div>div>button]:ml-30 [&>*>div>div]:gap-2 [&>*>div>img]:w-[6.5rem] [&>*>div>img]:h-[6.5rem] [&>*>div>h3]:text-nowrap [&>*>div>h3]:text-gray-500 [&>*>div>div>p]:text-sm [&>*>div>div>p]:text-gray-600 [&>*>div>div>p]:text-wrap 
        '>";
        
        foreach($products as $product) {
            $output .= renderProductCard($product);
        }
        
        $output .= "</div>";
        return $output;
    }
    return "<p>No products found for {$selectedSubcategory}.</p>";
}

function renderSubcategoryItem($subcategory) {
    return "<div class='flex justify-center items-center'>
                <a href='?view=products&subcategory=" . urlencode($subcategory['subcategory']) . "'>
                    <img src='" . htmlspecialchars($subcategory['imageURL']) . "' 
                         alt='Image of " . htmlspecialchars($subcategory['subcategory']) . "'/>
                </a>
                <p>" . htmlspecialchars($subcategory['subcategory']) . "</p>
            </div>";
}

function renderProductCard($product) {
    return "<div>
                <div>
                    <img alt='" . htmlspecialchars($product['name']) . "'
                         src='" . htmlspecialchars($product['imageURL']) . "'/>
                    <div>
                        <h3>" . htmlspecialchars($product['name']) . "</h3>
                        <p>" . htmlspecialchars($product['description']) . "</p>
                        <form action='order.php' target='noRerenderOnAddToOrderClick' method='post' class='flex justify-between items-center'>
                            <p class='text-sm ml-2 text-gray-500'>" . htmlspecialchars($product['price']) . "$</p>
                            <input type='hidden' name='product_id' value='" . htmlspecialchars($product['id']) . "'>
                            <input type='hidden' name='product_price' value='" . htmlspecialchars($product['price']) . "'>
                            <input type='hidden' name='product_name' value='" .$product['name']. "'>
                            <button type='submit' class='bg-[#346734] text-xs text-white font-semibold px-2 py-1 p-[0.08rem] w-[7rem] rounded-xs hover:bg-green-700 active:rounded-sm'>
                                <p>ADD TO ORDER</p>
                            </button>
                        </form>
                    </div>
                </div>
            </div>";
}

function displayMainContent() {
    $categories = getCategories();
    $selectedCategory = getSelectedCategory();
    
    $output = '<div class="flex justify-start items-start flex-col">';

    foreach ($categories as $category) {
        if ($category['category'] === $selectedCategory) {
            $output .= '<h1 class="text-lg font-semibold text-[#346734]">' . htmlspecialchars($category['category']) . '</h1>';
            $output .= '<h3 class="text-xs font-semibold text-gray-500 mb-2">Categories</h3>';
            
            $subcategories = getSubcategories($category['category']);
            if (!empty($subcategories)) {
                $output .= '<div class="flex justify-start items-start gap-3 flex-row *:flex-col *:text-center *:text-[0.65rem] *:text-gray-500 *:text-wrap [&>div>a>img]:border-1 [&>div>a>img]:border-gray-200 [&>div>a>img]:w-[4rem] [&>div>a>img]:h-[4rem] [&>div>p]:text-wrap [&>div>p]:w-[4rem]">';
                foreach ($subcategories as $subcategory) {
                    $output .= renderSubcategoryItem($subcategory);
                }
                $output .= '</div>';
            }
            break;
        }
    }
    
    $output .= '</div>';
    return $output;
}

function displayOrder() {
    if (!isset($_SESSION['order']) || empty($_SESSION['order'])) {
        return '<div class="flex justify-start items-start flex-col">
                    <h1 class="text-lg font-semibold text-[#346734]">Order</h1>
                    <hr class="border-[#346734] w-full mb-4" />
                    <p class="text-gray-500">Your order is empty</p>
                </div>';
    }

    global $conn;
    $output = '<div class="flex justify-start items-start flex-col">';
    $output .= '<h1 class="text-md font-semibold text-gray-700">Order</h1>';
    $output .= '<hr class="border-[#346734] w-full mb-4" />';
    $output .= '<div class="flex flex-col gap-4 w-1/3">';

    $total = 0;
    foreach ($_SESSION['order'] as $product_id => $ordered_product) {

        if ($ordered_product) {
            $subtotal = $ordered_product['price'] * $ordered_product['quantity'];
            $total += $subtotal;
            $output .= '<div class="flex justify-between items-center border-b border-gray-200 pb-2">';
            $output .= '<div class="flex flex-start items-center">';
            $output .= '<div class="flex flex-col justify-start items-center">';
            $output .= '<h1 class="text-gray-700">' . htmlspecialchars($ordered_product['name']) . '</h1>';
            $output .= '<div class="flex flex-row justify-between items-center">';
            $output .= '<p class="text-sm text-gray-500">Quantity: ' . $ordered_product['quantity'] . '</p>';
            $output .= '<div class="flex flex-col justify-between items-center ml-3  [&>*]:border-1 [&>*]:border-gray-300 [&>*]:bg-gray-200 [&>*]:text-[0.5rem] [&>*]:text-black [&>*]:cursor-pointer">';
            $output .= '<button id="increaseQuantity">▲</button>';
            $output .= '<button id="decreaseQuantity">▼</button>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '<div class="text-right">';
            $output .= '<p class="text-[#346734] font-semibold">$' . number_format($subtotal, 2) . '</p>';
            $output .= '</div>';
            $output .= '</div>';
        }
    }

    $output .= '<div class="flex justify-between items-center mt-4 pt-2 border-t border-gray-300">';
    $output .= '<h3 class="text-lg font-semibold text-gray-700">Total:</h3>';
    $output .= '<p class="text-lg font-bold text-[#346734]">$' . number_format($total, 2) . '</p>';
    $output .= '</div>';

    $output .= '</div></div>';
    return $output;
}

echo "<!-- Database connection successful -->\n";
$cats = getCategories();
echo "<!-- Found " . count($cats) . " categories -->\n";
?>