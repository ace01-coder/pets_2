<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Sidebar</title>
 <!--<script src="https://cdn.tailwindcss.com"></script>--> 
 <link rel="stylesheet" href="/public/style.css">
</head>
<body class="bg-gray-100 ">
    <!--Navbar-->
    <nav class=" bg-gray-800">
        <div class="flex text-white p-5 justify-between">
         <div class="flex">
          <button id="toggleSidebar" class="">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
              </svg>
            </button> 
         </div>
            <div class="">
              <div class="">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAAEIElEQVR4nO2aSWyNURTHXyklKqgqMYRamQmJsCeGpCgrylJY6cDGBrFCWNVQIRZWYmmoYUElYiaIGKpEzCkikRha2p8cPS+5efne9917362W9J80fXn3DN//nXvPPffcL5XqwX8KYDCwBNgFnAQeAR+A7/onnx8CJ1SmDBiU6g4ACoAK4CzwC3eIzhlgldhKdQGBfkAN8MZ4qB9AA7AVKAcmA0NVtp9+ngIsV5lLQIuh/xqoEtm/RWIR0GQ8wG1gHTDEw9YQ1b1j2HsKLOjsKOw3HIrzhYFs5+kPdNewXxt8ugHDgVvq4BtQCfQO6qTDTz5QrclBcAMoCWV8nIZb8BiYmiA/EdgMXASeKfGvwHPgKDDXwud0oFF9yv9xISKRJnFNFmyMbDFwBGhLyFTtwHaRT/BdDFw3yJTksibS0+kqUBgjWwI8wA0/gYPAgBi7hQaZG15rBjhgTKe4SPQCLuMP0e2bEJlGld3rSmKxKn6zWBMryB2bEnzMMBKAXWoG+usiFWywkJdyJFe8sPBTrbKNVlMM2GjsE70t8v8XwmC8RWq+p7KVNgv8jW0IgWGEwzyHKf86NirAahW8lWRU5UcEJLLMwl+eUc6sjBM8r0JrLYlI2g0Fq0UMrFf5+rgC7pdWsYMtjQ7UDS4EJlj6LNKq+WfkeUZCqwYv2Bg09F4GINHmUr7TcQQQlEUN7tbBLY5E6gMQue/oc5vq7YoaPKWDSx2N7gtA5Iijz3LVOxE1mC4DJjoYlPLkXQAib8VWyt6vnD4Fj6MGP+lgkYNBWXih4OI3vX81Rw2mz89ZC7gInT5aj+WKHy6VLR1Njz96QYionnRQcsUZR58FqtcSZGqp3iw9AfpCdGc6+ixW3Y9xi91qY8qSRXxQ7uFvUtxir/dJv0aomz1IvHedyhmb96lUJoA9Phuiob/Jg0iNp6+tcRuiV4mSkcFuOpCQM3i+p6+GuBJlqBZi1kVjhI3RDkRGefoo0gzbmvU5gXMuZXyWqNjCNxrrVP90nNAaFbrj6UTaN7Yo9LCfZxysKpKyT/qo69zXBUodiJR62F+suq8Ss52Rfe66hF9bq9KNtIU0/cY62M+Xcl91q2wUCox2UKICMBs45Lm7i85hYI6FnxrVabTeezSE7doUm5alRNiQcQ2QK+TXro7q8RoNunbnKW+0TJ+kG87aJT+WcdMUGq3AcXl4o2RPN9JrnUgYHcfrxnzeZ9FpD4k2oM5Yd1e8r+W0byX3Gl2NZ3LF4UXCIDPGCG1X4LlPqs5GZqRjag2FKzIrgpDI6AvXBWzIxaFd12Tn3b1L+uvkddMEzO80AhGbZrW2cUJBSqNKn4NWCEJ99fWLs5r/XdGir3CslMo51R2gTXA5nO3UY7O8QPPZeOjP+p2M7ZAjtc/bEj1I/SP4DZI1epJ9LEGlAAAAAElFTkSuQmCC">
              </div>
            </div>
        </div>
    </nav>
    <div class="flex">
      <div id="sidebar" class=" bg-gray-800 text-white w-64 h-screen p-5 space-y-5 transition-all duration-300">
        <div class=" flex justify-center items-center">
          <img width="70" height=""  src="/public/img/BARANGAY_PAW_PATROL_SYSTEM-removebg-preview.png" alt="">
        </div>
        <ul class="">
          <li class="flex items-center space-x-3 space-y-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M9 16l-6-6 6-6" />
            </svg>
            <span class="sidebar-text">Dashboard</span>
          </li>
          <li class="flex items-center space-x-3 space-y-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M9 16l-6-6 6-6" />
            </svg>
            <span class="sidebar-text">Our animal</span>
          </li>
          <li class="flex items-center space-x-3 space-y-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M9 16l-6-6 6-6" />
            </svg>
            <span class="sidebar-text">Contact</span>
          </li>
          <li class="flex items-center space-x-3 space-y-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M9 16l-6-6 6-6" />
            </svg>
            <span class="sidebar-text">Blog's</span>
          </li>
          <li class="flex items-center space-x-3 space-y-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M9 16l-6-6 6-6" />
            </svg>
            <span class="sidebar-text">About</span>
          </li>
        </ul>
      </div>  
      <div class="relative w-full bg-gray-400">
        <h2 class="font-bold text-xl  md:ml-6 md:mt-3">LATEST RECORDS</h2>
         <div class="flex justify-evenly">
            <div class="flex flex-col px-10 mx-2  rounded-lg bg-white">
              <h2 class="font-bold">header</h2>
              <span>acefelixerpmanganaan</span>
            </div>
            <div class="flex flex-col px-10 mx-2  rounded-lg bg-white">
              <h2 class="font-bold">header</h2>
              <span>acefelixerpmanganaan</span>
            </div>
            <div class="flex flex-col px-10 mx-2  rounded-lg bg-white">
              <h2 class="font-bold">header</h2>
              <span>acefelixerpmanganaan</span>
            </div>
            <div class="flex flex-col px-10 mx-2  rounded-lg bg-white">
              <h2 class="font-bold">header</h2>
              <span>acefelixerpmanganaan</span>
            </div>
         </div>
         <div class="mx-2">
          <h2 class="font-bold text-xl  md:ml-6 md:mt-3">LIST</h2>
          <table class="w-full bg-white rounded-lg shadow-lg">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Name</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Age</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Occupation</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Occupation</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <tr>
                    <td class="text-left m py-3 px-2">John Doe</td>
                    <td class="text-left m py-3 px-2">28</td>
                    <td class="text-left py-3 px-4">Software Engineer</td>
                    <td class="text-left py-3 px-4">Software Engineer</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="text-left m py-3 px-2">Jane Smith</td>
                    <td class="text-left m py-3 px-2">34</td>
                    <td class="text-left m py-3 px-2">Data Scientist</td>
                    <td class="text-left m py-3 px-2">Data Scientist</td>
                </tr>
                <tr>
                    <td class="text-left m py-3 px-2">Paul Walker</td>
                    <td class="text-left m py-3 px-2">45</td>
                    <td class="text-left m py-3 px-2">Manager</td>
                    <td class="text-left m py-3 px-2">Manager</td>
                </tr>
                <tr>
                  <td class="text-left m py-3 px-2">Paul Walker</td>
                  <td class="text-left m py-3 px-2">45</td>
                  <td class="text-left m py-3 px-2">Manager</td>
                  <td class="text-left m py-3 px-2">Manager</td>
              </tr>
              <tr>
                <td class="text-left m py-3 px-2">John Doe</td>
                <td class="text-left m py-3 px-2">28</td>
                <td class="text-left py-3 px-4">Software Engineer</td>
                <td class="text-left py-3 px-4">Software Engineer</td>
            </tr>
            <tr>
              <td class="text-left m py-3 px-2">John Doe</td>
              <td class="text-left m py-3 px-2">28</td>
              <td class="text-left py-3 px-4">Software Engineer</td>
              <td class="text-left py-3 px-4">Software Engineer</td>
          </tr>
          <tr>
            <td class="text-left m py-3 px-2">John Doe</td>
            <td class="text-left m py-3 px-2">28</td>
            <td class="text-left py-3 px-4">Software Engineer</td>
            <td class="text-left py-3 px-4">Software Engineer</td>
        </tr>
            </tbody>
        </table>
         </div>
      </div>
  </div> 
  <script src="/public/script.js"></script>

</body>
</html>
