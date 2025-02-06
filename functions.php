<?php
session_start();
require_once 'db_connection.php';

function getCategories() {
    global $conn;
    $sql = "SELECT * FROM categories";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getSelectedCategory() {
    $selected = isset($_GET['category']) ? $_GET['category'] : $_SESSION['selectedCategory'];
    return $selected;
}

function renderCategoryItem($category, $isActive) {
    return "<li class='{$isActive}'><a href='?category=" . 
           urlencode($category['category']) . "'>" . $category['category'] . "</a></li>";
}

function displayCategories() {
    $categories = getCategories();
    $selectedCategory = getSelectedCategory();
    $_SESSION['selectedCategory'] = $selectedCategory;
    
    $str = '';
    if (!empty($categories)) {
        foreach ($categories as $category) {
            $isActive = ($category['category'] === $selectedCategory) ? 'bg-yellow-100' : '';
            $str .= renderCategoryItem($category, $isActive);
        }
    }
    
    return $str;
}

function getSubcategories($category) {
    global $conn;
    $sql = "SELECT * FROM subcategories WHERE category = '$category'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


function getProducts($subcategory) {
    global $conn;
    $sql = "SELECT * FROM products WHERE subcategory = '$subcategory'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function displayProducts() {
    $selectedSubcategory = isset($_GET['subcategory']) ? $_GET['subcategory'] : '';
    $products = getProducts($selectedSubcategory);
    $selectedCategory = $products[0]['category'];
    $_SESSION['selectedCategory'] = $selectedCategory;

    
    $str = '<h1 class="text-lg font-semibold text-[#346734]">' . htmlspecialchars($selectedCategory) . '</h1>
                <hr class="border-[#346734] w-full" />
                <div class="flex justify-start items-start flex-col">
                <header class="text-sm font-regular mb-1 text-gray-500">' . htmlspecialchars($selectedSubcategory) . '</header>
                </div>
                <hr class="w-full" />';
                
    if (!empty($products)) {
        $str .= "<div class='flex flex-row flex-wrap justify-start items-start my-3 gap-3'>";
        
        foreach($products as $product) {
            $str .= renderProductCard($product);
        }
        
        $str .= "</div>";
        return $str;
    }
    return '<p>No products found for ' . htmlspecialchars($selectedSubcategory) . '.</p>';
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
    $currentView = isset($_GET['subcategory']) ? '&subcategory=' . urlencode($_GET['subcategory']) : '';

    if ($product['stock'] == 0 && (!in_array($product['id'], $_SESSION['outOfStockItems']))) {
        $_SESSION['outOfStockItems'][] = $product['id'];
    }

    if (isset($_SESSION['outOfStockItems']) && (in_array($product['id'], $_SESSION['outOfStockItems']))) {
        $inStock = 'Out of Stock';
        $stockClass = 'text-red-800';
        $buttonActive = 'bg-gray-300 cursor-not-allowed';
        $buttonText = 'OUT OF STOCK';
        $submitPermitted = '';
    } else {
        $inStock = 'In Stock';
        $stockClass = 'text-green-800';
        $buttonActive = 'bg-[#346734] hover:bg-green-700 active:rounded-sm cursor-pointer';
        $buttonText = 'ADD TO ORDER';
        $submitPermitted = 'submit';
    }

    return "<div class='border-1 border-gray-300 rounded-xs w-[28rem] h-[9rem] flex flex-row justify-between items-center py-3 px-5 gap-4'>
                <img
                        class='w-24 h-24'
                    alt='" . htmlspecialchars($product['name']) . "'
                    src='" . htmlspecialchars($product['imageURL']) . "'/>
                <div class='h-full w-full flex flex-col justify-between'>
                    <div class='flex flex-col justify-between gap-2'>
                        <h3 class='text-nowrap text-gray-500'>" . htmlspecialchars($product['name']) . "</h3>
                        <p class='text-sm text-gray-600'>" . htmlspecialchars($product['description']) . "</p>
                    </div>
                    <form action='order.php'  method='post' class='flex justify-between items-center'>
                        <p class='text-sm ml-2 text-gray-500'>$" . htmlspecialchars($product['price']) . "</p>
                        <input type='hidden' name='product_id' value='" . htmlspecialchars($product['id']) . "'>
                        <input type='hidden' name='product_price' value='" . htmlspecialchars($product['price']) . "'>
                        <input type='hidden' name='product_name' value='" .$product['name']. "'>
                        <input type='hidden' name='max_quantity' value='".$product['stock']."'>
                        <input type='hidden' name='redirect' value='products" . $currentView . "'>
                        <p class='text-xs {$stockClass}'>{$inStock}</p> 
                        <button type='{$submitPermitted}' class='{$buttonActive} text-xs text-white font-semibold px-2 py-1 w-[7rem] rounded-xs'>
                            <p>{$buttonText}</p>
                        </button>
                    </form>
                </div>
            </div>";
}


function displayMainContent() {
    $categories = getCategories();
    $selectedCategory = getSelectedCategory();
    
    $str = '<div class="flex justify-start items-start flex-col">';

    foreach ($categories as $category) {
        if ($category['category'] === $selectedCategory) {
            $str .= '<h1 class="text-lg font-semibold text-[#346734]">' . htmlspecialchars($category['category']) . '</h1>
                        <h3 class="text-xs font-semibold text-gray-500 mb-2">Categories</h3>';
            
            $subcategories = getSubcategories($category['category']);
            if (!empty($subcategories)) {
                $str .= '<div class="flex justify-start items-start gap-3 flex-row *:flex-col *:text-center *:text-[0.65rem] *:text-gray-500 *:text-wrap [&>div>a>img]:border-1 [&>div>a>img]:border-gray-200 [&>div>a>img]:w-[4rem] [&>div>a>img]:h-[4rem] [&>div>p]:text-wrap [&>div>p]:w-[4rem]">';
                foreach ($subcategories as $subcategory) {
                    $str .= renderSubcategoryItem($subcategory);
                }
                $str .= '</div>';
            }
            break;
        }
    }
    
    $str .= '</div>';
    return $str;
}

function displayOrder() {
    if (!isset($_SESSION['order']) || empty($_SESSION['order'])) {
        return '<div class="flex justify-start items-start flex-col">
                    <h1 class="text-lg font-semibold text-[#346734]">Order</h1>
                    <hr class="border-[#346734] w-full mb-4" />
                    <p class="text-gray-500">Your order is empty</p>
                </div>';
    }


    if (isset($_SESSION['user_id'])) {
        $str = <<<HTML
            <div class="flex justify-start items-start flex-col">
            <div class="flex flex-row justify-between items-between w-full">
                    <h1 class="text-md font-semibold text-gray-700">Order</h1>
                    <p class="text-red-400 mr-3">{$_SESSION['order_error']}</p>
                </div>
                <hr class="border-[#346734] w-full my-2" />
                <div class="flex flex-row justify-between items-start w-full">
                    <div class="flex flex-col gap-4 w-1/3">
            HTML;
    } else {
        $str = <<<HTML
            <div class="flex justify-start items-start flex-col">
                <div class="flex flex-row justify-between items-between w-full">
                    <h1 class="text-md font-semibold text-gray-700">Order</h1>
                    <p class="text-red-400 mr-3">Please login to checkout</p>
                </div>
                <hr class="border-[#346734] w-full my-2" />
                <div class="flex flex-row justify-between items-start w-full">
                    <div class="flex flex-col gap-4 w-1/3">
            HTML;
    }
    $total = 0;

    foreach ($_SESSION['order'] as $product_id => $ordered_product) {

        if ($ordered_product) {
            $subtotal = $ordered_product['price'] * $ordered_product['quantity'];
            $total += $subtotal;
            $formattedSubtotal = number_format($subtotal, 2);
            $formattedTotal = number_format($total, 2);
            
            if ($ordered_product['quantity'] >= $ordered_product['max_quantity']) {
                $buttonActive = '';
                $stockWarningText = 'Max quantity reached';
            } else {
                $stockWarningText = '';
                $buttonActive = 'submit';
            }

            $str .= <<<HTML
                <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                    <div class="flex flex-start items-center">
                        <div class="flex flex-col justify-start items-start">
                            <h1 class="text-gray-700 text-md">{$ordered_product['name']}</h1>
                            <div class="flex flex-row justify-start items-center">
                                <p class="text-sm text-gray-500">Quantity: {$ordered_product['quantity']}</p>
                                <form action="order.php" method="post" class="flex flex-col justify-between items-center ml-3  [&>*]:border-1 [&>*]:w-[0.7rem] [&>*]:h-[0.8rem] [&>*]:border-gray-300 [&>*]:bg-gray-100 [&>*]:text-[0.5rem] [&>*]:text-black [&>*]:cursor-pointer">
                                    <button href="?view=order" type="{$buttonActive}" name="increaseQuantity" id="increaseQuantity" value="$product_id">
                                    ▲
                                    </button>
                                    <button href="?view=order" type="submit" name="decreaseQuantity" id="decreaseQuantity" value="$product_id">
                                    ▼
                                    </button>
                                </form>
                                <p class="text-sm text-gray-500 ml-3">$stockWarningText</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-[#346734] font-semibold"><span>$</span>$formattedSubtotal</p>
                    </div>
                </div>
    HTML;
        }
    }

    $str .= <<<HTML
        <div class="flex justify-between items-center mt-4 pt-2 border-t border-gray-300">
            <h3 class="text-md font-semibold text-gray-500">Total:</h3>
            <p class="text-lg font-bold text-[#346734]"><span>$</span>$formattedTotal</p>
        </div>
    </div>
HTML;

    if (isset($_SESSION['order_error'])) {
        $str .= <<<HTML
            <div class="w-1/3 flex justify-start items-start flex-col">
                <p class="text-red-500">{$_SESSION['order_error']}</p>
            </div>
HTML;
        unset($_SESSION['order_error']);
    }

    if (isset($_SESSION['user_id'])) {
        $str .= <<<HTML
            <div class="w-1/3 border-1 px-5 py-3 border-[#346734] flex flex-col justify-start items-start">
                <h1>Checkout</h1>
                <hr class="border-[#346734] w-full my-4 border-1" />
                <form action="order.php" method="post" class="w-full flex flex-col justify-center items-start gap-4 [&>input]:border-1 [&>input]:border-gray-300 [&>input]:px-2 [&>input]:py-1 [&>input]:text-sm [&>input]:text-gray-500 [&>input]:w-full">
                    <h2 class="text-sm font-semibold text-gray-500">Postal Information</h2>
                    <input type="text" name="name" id="name" pattern="[A-Za-z]+" placeholder="Name" />
                    <input type="text" name="lastname" id="lastname" pattern="[A-Za-z]+" placeholder="Last Name" />
                    <input type="text" name="address" id="address" placeholder="Address" />
                    <input type="text" name="city" id="city" pattern="[A-Za-z]+" placeholder="City" />
                    <input type="text" name="postalCode" id="postalCode" pattern="\d{2}/\d{3}" placeholder="Postal Code: XX-XXX" />
                    <input type="tel" name="phone" id="phone" placeholder="Phone Number" />
                    <hr class="w-full mb-1 border-1 border-gray-300" />
                    <h2 class="text-sm font-semibold text-gray-500">Payment Information</h2>
                    <input type="number" name="creditCard" pattern="\d{16}" id="creditCard" placeholder="Credit Card Number" />
                    <input type="number" name="expirationDate" pattern="\d{2}/\d{2}" id="expirationDate" placeholder="Expiration Date: MM/YY" />
                    <input type="number" name="cvv" pattern="\d{3}" id="cvv" placeholder="CVV" />
                    <input type="hidden" name="total" id="total" value="{$total}" />
                    <div class="flex justify-center items-center w-full my-3">
                        <button type="submit" name="checkout" class="w-2/3 bg-[#346734] text-white font-semibold px-4 py-2 active:rounded-sm hover:bg-green-700">Checkout</button>
                    </div>
                </form>
            </div>
    HTML;
    } else {
        
        $str .= '<p></p>';
    }
    $str .= '</div></div>';
    return $str;
}

function displayOrderConfirmed() {
    global $conn;
    $id = $_SESSION['last_order_id'];
    $sql = "SELECT * FROM orders WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $order = mysqli_fetch_assoc($result);
    $products = json_decode($order['products'], true);
    $str = '<div class="flex justify-start items-start flex-col">
                <h1 class="text-lg font-semibold text-[#346734]">Order #' . $order['id'] . ' Confirmed</h1>
                <hr class="border-[#346734] w-full mb-4" />
                <p class="text-gray-500 mb-3">Summary</p>
                <p class="text-gray-500">Total: $' . $order['total'] . '</p>
                <p class="text-gray-500">Order date: ' . $order['created_at'] . '</p>
                <p class="text-gray-500">Order status: ' . $order['status'] . '</p>
                <p class="text-gray-500 my-3">Products ordered:</p><ul>';
    foreach ($products as $product) {
        $str .= '<li class="flex flex-row justify-start items-start"><p class="text-gray-500">' . $product['name'] . '&nbsp;&nbsp;-</p>
                    <p class="ml-3 text-gray-500">' . $product['quantity'] . ' pieces</p></li>';
    }
    $str .= '</ul></div>';
    return $str;
}

function displayOrderHistory() {
    global $conn;
    $userId = $_SESSION['user_id'];
    $sql = "SELECT * FROM orders WHERE userId = $userId";
    $result = mysqli_query($conn, $sql);
    
    $str = '<div class="flex justify-start items-start flex-col w-full">
    <h1 class="text-lg font-semibold text-[#346734]">Order History</h1>
    <hr class="border-[#346734] w-full mb-4" />
    <div class="flex flex-col gap-4 justify-start items-start w-full">';
    
    if (mysqli_num_rows($result) == 0) {
        $str .= '<p class="text-gray-500">No orders found</p></div></div>';
        return $str;
    }
    
    $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
    

    foreach ($orders as $order) {
        $productsList = '';
        $products = json_decode($order['products'], true);
        foreach ($products as $product) {
            $productsList .= '<li class="text-gray-500">' . $product['name'] . ' - ' . $product['quantity'] . ' pieces</li>';
        }

        $str .= '<div class="flex flex-col gap-2 justify-start items-start border-b border-gray-400 py-3 w-1/3">
                        <p class="text-gray-500">Order #' . $order['id'] . '</p>
                        <p class="text-gray-500">Total: $' . $order['total'] . '</p>
                        <p class="text-gray-500">Order date: ' . $order['created_at'] . '</p>
                        <p class="text-gray-500">Order status: ' . $order['status'] . '</p>
                        <details class="text-gray-500">
                            <summary class="text-gray-500">Ordered products</summary>
                            <ul>
                                ' . $productsList . '
                            </ul>
                        </details>
                </div>';
    }

    return $str;
}

function displayAllSubcategories() {
    global $conn;
    $sql = "SELECT * FROM subcategories";
    $result = mysqli_query($conn, $sql);
    $subcategories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $str = '<div class="flex justify-start items-start flex-col">
                <h1 class="text-lg font-semibold text-[#346734]">All Categories</h1>
                <hr class="border-[#346734] w-full mb-4" />
                <div class="flex flex-row flex-wrap justify-start items-start gap-4 *:flex-col *:text-center *:text-[0.7rem] *:text-gray-700 *:text-wrap [&>div>a>img]:border-1 [&>div>a>img]:border-gray-200 [&>div>a>img]:w-[4rem] [&>div>a>img]:h-[4rem] [&>div>p]:text-wrap [&>div>p]:w-[4rem]">';
    foreach ($subcategories as $subcategory) {
        $str .= renderSubcategoryItem($subcategory);
    }
    $str .= '</div>';
    return $str;
}

?>