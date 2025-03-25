
//card container-start
/*function showPopup(title, description) {
  // Show overlay
  document.getElementById('overlay').classList.remove('hidden');
  
  // Populate popup with information
  document.getElementById('popupTitle').textContent = title;
  document.getElementById('popupDescription').textContent = description;
  
  // Display popup
  const popupContainer = document.getElementById('popupContainer');
  popupContainer.classList.remove('hidden');
}

function closePopup() {
  // Hide overlay and popup
  document.getElementById('overlay').classList.add('hidden');
  document.getElementById('popupContainer').classList.add('hidden');
}

//card container-end
*/

//start:sidebar

 //Sidebar functions
 const toggleBtn = document.getElementById('toggleBtn');
 const sidebarToggle = document.getElementById('sidebarToggle');
 const sidebar = document.getElementById('sidebar');

 function toggleSidebar() {
   sidebar.classList.toggle('w-20');
   sidebar.classList.toggle('w-64');
   sidebar.classList.toggle('sidebar-expanded');
 
 }
  // Event Listeners
  toggleBtn.addEventListener('click', toggleSidebar);
  sidebarToggle.addEventListener('click', toggleSidebar);

 

  function toggleDropdown(dropdownContentId, arrowIconId) {
    // Get all dropdown contents and arrow icons
    const allDropdownContents = document.querySelectorAll('.dropdown-content');
    const allArrowIcons = document.querySelectorAll('.sidebar-text svg');
  
    // Loop through all dropdowns and close them
    allDropdownContents.forEach((content) => {
      if (content.id !== dropdownContentId) {
        content.classList.add('hidden'); // Close other dropdowns
      }
    });
  
    allArrowIcons.forEach((icon) => {
      if (icon.id !== arrowIconId) {
        icon.classList.remove('rotate-90'); // Reset other arrow rotations
      }
    });
  
    // Toggle the current dropdown and arrow
    const dropdownContent = document.getElementById(dropdownContentId);
    const arrowIcon = document.getElementById(arrowIconId);
  
    dropdownContent.classList.toggle('hidden'); // Toggle visibility
    arrowIcon.classList.toggle('rotate-90'); // Rotate arrow
  }
  //end:sidebar

  