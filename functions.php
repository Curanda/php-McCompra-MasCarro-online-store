<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli('localhost', 'root', '', 'mccompra_mascarro');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Category Functions
function getCategories() {
    global $conn;
    $result = $conn->query("SELECT * FROM categories");
    if (!$result) {
        die("Query failed: " . $conn->error);
    }
    return $result->fetch_all(MYSQLI_ASSOC); // Convert result to array
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

// Subcategory Functions
function getSubcategories($category) {
    global $conn;
    $result = $conn->query("SELECT * FROM subcategories WHERE category = '" . 
        $conn->real_escape_string($category) . "'");
    if (!$result) {
        die("Query failed: " . $conn->error);
    }
    return $result->fetch_all(MYSQLI_ASSOC); // Convert result to array
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

// Product Functions
function getProducts($subcategory) {
    global $conn;
    $result = $conn->query("SELECT * FROM products WHERE subcategory = '" . 
        $conn->real_escape_string($subcategory) . "'");
    if (!$result) {
        die("Query failed: " . $conn->error);
    }
    return $result->fetch_all(MYSQLI_ASSOC); // Convert result to array
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
        $output .= "<div class='flex flex-row justify-start items-start my-3 gap-3 [&>*]:border-1 [&>*]:border-gray-300 [&>*]:rounded-xs [&>*]:w-[25rem] [&>*>div]:flex [&>*>div]:flex-row [&>*>div]:justify-start [&>*>div]:items-center [&>*>div]:p-3 [&>*>div]:gap-3 [&>*>div>div]:flex [&>*>div>div]:flex-col [&>*>div>div>button]:ml-30 [&>*>div>div]:gap-2 [&>*>div>img]:w-[6.5rem] [&>*>div>img]:h-[6.5rem] [&>*>div>h3]:text-nowrap [&>*>div>h3]:text-gray-500 [&>*>div>div>p]:text-sm [&>*>div>div>p]:text-gray-600 [&>*>div>div>p]:text-wrap [&>*>div>div>button]:bg-[#346734] [&>*>div>div>button]:text-xs [&>*>div>div>button]:text-white [&>*>div>div>button]:font-semibold [&>*>div>div>button]:px-2 [&>*>div>div>button]:py-1 [&>*>div>div>button]:p-[0.08rem] [&>*>div>div>button]:w-[7rem] [&>*>div>div>button]:rounded-xs [&>*>div>div>button]:hover:bg-green-700 [&>*>div>div>button]:active:rounded-sm'>";
        
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
                        <button>
                            <p>ADD TO ORDER</p>
                        </button>
                    </div>
                </div>
            </div>";
}

function displayMainContent() {
    $categories = getCategories();
    $selectedCategory = getSelectedCategory();
    
    $output = '<div class="flex justify-start items-start flex-col">';
    
    // Only show the active category's content
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
            break; // Exit the loop after showing the active category
        }
    }
    
    $output .= '</div>';
    return $output;
}

// Add some debug output
echo "<!-- Database connection successful -->\n";
$cats = getCategories();
echo "<!-- Found " . count($cats) . " categories -->\n";
?>