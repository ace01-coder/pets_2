const table = document.getElementById('petTable');
const rows = table.querySelectorAll('tbody tr');
const petNames = [];
const petAges = [];
const diseases = {};

rows.forEach(row => {
  const cells = row.querySelectorAll('td');
  const petName = cells[0].innerText; // Pet Name
  const petAge = parseInt(cells[3].innerText); // Pet Age
  const vaccinationClass = cells[4].innerText; // Vaccination Class

  petNames.push(petName);
  petAges.push(petAge);

 
  if (diseases[vaccinationClass]) {
    diseases[vaccinationClass]++;
  } else {
    diseases[vaccinationClass] = 1;
  }
});


const ctxAge = document.getElementById('petAgeChart').getContext('2d');
const petAgeChart = new Chart(ctxAge, {
  type: 'bar',
  data: {
    labels: petNames,
    datasets: [{
      label: 'Pet Age',
      data: petAges,
      backgroundColor: 'rgba(54, 162, 235, 0.2)',
      borderColor: 'rgba(54, 162, 235, 1)',
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});


const diseaseNames = Object.keys(diseases);
const diseaseCounts = Object.values(diseases);
const ctxDisease = document.getElementById('diseaseChart').getContext('2d');
const diseaseChart = new Chart(ctxDisease, {
  type: 'doughnut',
  data: {
    labels: diseaseNames,
    datasets: [{
      label: 'Disease Percentage',
      data: diseaseCounts,
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
      ],
      borderColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
      ],
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'top',
      },
    }
  }
});