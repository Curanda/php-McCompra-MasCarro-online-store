<?php
session_start();
require_once 'functions.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Hind+Vadodara:wght@700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=search"
    />
    <title>McCOMPRA-MasCARRO</title>
  </head>
  <body>
    <nav class="px-5 pt-3">
      <div class="flex justify-between items-center flex-row">
        <div class="flex items-center justify-start">
          <h1
            style="
              font-family: 'Hind Vadodara', sans-serif;
              letter-spacing: -1px;
              font-size: 2.2rem;
              color: #346734;
              transform: scaleX(0.75);
              transform-origin: left;
            "
          >
            McCOMPRA-MasCARRO
          </h1>
          <p class="text-xs ml-[-5.5rem] mt-5 text-[#346734]">&#xA9;</p>
        </div>
        <div
          class="flex justify-center items-start flex-1 mx-4 font-bold"
          id="searchBar"
        >
          <div
            class="border-1 border-gray-500 w-3/5 flex flex-row justify-between font-normal"
          >
            <input
              type="text"
              placeholder="Search"
              class="border-0 focus:outline-none px-1 py-1"
            />
            <button class="text-xs mr-1 mt-1">
              <span class="material-symbols-outlined text-gray-500"
                >search</span
              >
            </button>
          </div>
        </div>
        <div class="flex justify-end items-end flex-col">
          <ul
            class="flex space-x-4 text-xs text-gray-600 [&>*]:hover:underline"
          >
            <li><a href="#">(630) 833-0300</a></li>
            <li>|</li>
            <li><a href="#"> Email Us</a></li>
            <li>|</li>
            <style>
              #login:checked ~ #loginMenu {
                display: flex;
              }
              #createLogin:checked ~ #createLoginMenu {
                display: flex;
              }
              #login:checked ~ #createLoginMenu {
                display: none;
              }
              #createLogin:checked ~ #loginMenu {
                display: none;
              }
            </style>
            <li class="relative">
              <input
                type="radio"
                id="login"
                name="menuState"
                class="hidden peer"
              />
              <input
                type="radio"
                id="createLogin"
                name="menuState"
                class="hidden peer"
              />
              <input
                type="radio"
                id="closeMenu"
                name="menuState"
                class="hidden peer"
                checked
              />
              <label for="login" class="hover:underline cursor-pointer"
                >Log in ▼</label
              >

              <div
                id="loginMenu"
                class="hidden absolute w-[20rem] mt-3 mr-3 px-7 py-5 right-1 top-full min-w-max drop-shadow-2xl bg-white border-t-2 border-yellow-500 transition delay-75 ease-in-out z-10 flex-col p-4 gap-3"
              >
                <div class="flex justify-between items-center mb-2">
                  <h2 class="font-bold text-lg text-[#346734]">Log in</h2>
                  <label
                    for="closeMenu"
                    class="text-gray-500 hover:text-gray-600 text-xl cursor-pointer"
                  >
                    &cross;
                  </label>
                </div>
                <div class="flex flex-col gap-1">
                  <input
                    type="text"
                    placeholder="Email"
                    class="px-3 py-2 border-1 border-gray-500"
                  />
                </div>
                <div class="flex flex-col gap-1">
                  <input
                    type="password"
                    placeholder="Password"
                    class="px-3 py-2 border-1 border-gray-500"
                  />
                </div>
                <div class="flex justify-between items-center py-2">
                  <div class="flex items-center gap-2">
                    <input type="checkbox" id="stayLoggedIn" />
                    <label for="stayLoggedIn" class="text-xs"
                      >Stay logged in</label
                    >
                  </div>
                  <a
                    href="#"
                    class="text-gray-500 hover:bg-yellow-200 text-xs underline"
                    >Reset Password</a
                  >
                </div>
                <div class="flex flex-col gap-2">
                  <button
                    class="bg-[#346734] text-white py-1 rounded-sm hover:bg-green-700"
                  >
                    Log in
                  </button>
                  <label
                    for="createLogin"
                    class="border border-[#346734] text-center text-[#346734] py-1 rounded-sm hover:bg-green-50 cursor-pointer"
                  >
                    Create login
                  </label>
                </div>
              </div>

              <div
                id="createLoginMenu"
                class="hidden absolute w-[20rem] mt-3 mr-3 px-7 py-5 right-1 top-full min-w-max drop-shadow-2xl bg-white border-t-2 border-yellow-500 transition delay-75 ease-in-out z-10 flex-col p-4 gap-3"
              >
                <div class="flex justify-between items-center mb-2">
                  <h2 class="font-bold text-lg text-[#346734]">Create login</h2>
                  <label
                    for="closeMenu"
                    class="text-gray-500 hover:text-gray-600 text-xl cursor-pointer"
                  >
                    &cross;
                  </label>
                </div>
                <div class="flex flex-col gap-1">
                  <input
                    type="text"
                    placeholder="Name"
                    class="px-3 py-2 border-1 border-gray-500"
                  />
                </div>
                <div class="flex flex-col gap-1">
                  <input
                    type="text"
                    placeholder="Email"
                    class="px-3 py-2 border-1 border-gray-500"
                  />
                </div>
                <div class="flex flex-col gap-1">
                  <input
                    type="password"
                    placeholder="Password"
                    class="px-3 py-2 border-1 border-gray-500"
                  />
                </div>
                <div class="flex justify-between items-center py-2">
                  <div class="flex items-center gap-2">
                    <input type="checkbox" id="agreeToTerms" />
                    <label for="agreeToTerms" class="text-xs"
                      >I agree to
                      <a href="#" class="underline"
                        >Terms and Conditions</a
                      ></label
                    >
                  </div>
                  <a
                    href="#"
                    class="text-gray-500 hover:bg-yellow-200 text-xs underline"
                    >Reset Password</a
                  >
                </div>
                <div class="flex flex-col gap-2">
                  <button
                    class="bg-[#346734] text-white py-1 rounded-sm hover:bg-green-700"
                  >
                    Create login
                  </button>
                </div>
                <label
                  for="login"
                  class="text-xs underline text-gray-500 cursor-pointer"
                >
                  Back to login
                </label>
              </div>
            </li>
          </ul>
          <div class="flex gap-10 justify-end items-end w-full">
            <button class="text-[#346734] font-bold py-2 rounded-md">
              ORDER
            </button>
            <button class="text-[#346734] font-bold py-2 rounded-md">
              ORDER HISTORY
            </button>
          </div>
        </div>
      </div>
    </nav>
    <hr class="border-yellow-400 border-[1px]" />
    <section class="flex justify-start items-start">
      <aside
        id="sideBar"
        class="w-1/7 h-screen border-r border-gray-400 m-2 mr-5 text-nowrap"
      >
      <div class="flex justify-start items-start flex-col px-3">
          <header class="text-sm text-nowrap font-regular mb-1">
            Choose a Category
          </header>
          <hr class="border-[#346734] w-full" />
          <ul
            class="flex w-full space-x-4 space-y-2 flex-col text-xs mt-2 text-gray-800 [&>*]:hover:bg-yellow-100 [&>*]:hover:cursor-pointer [&>*]:hover:underline [&>*]:pb-2 [&>*]:active:bg-yellow-300 [&>*]:active:underline"
          >
            <?php 
              $categories = displayCategories();
          if (empty($categories)) {
              echo "No categories found";
          } else {
              echo $categories;
          }
        ?>
        </ul>
        </div>
      </aside>
      <main id="detailedView" class="w-full m-2">
        <?php
        if (isset($_GET['view']) && $_GET['view'] === 'products' && isset($_GET['subcategory'])) {
            $products = displayProducts();
            if (empty($products)) {
                echo "No products found";
            } else {
                echo $products;
            }
        } else {
            $mainContent = displayMainContent();
            if (empty($mainContent)) {
                echo "No main content found";
            } else {
                echo $mainContent;
            }
        }
        ?>
      </main>
    </section>
  </body>
</html>
