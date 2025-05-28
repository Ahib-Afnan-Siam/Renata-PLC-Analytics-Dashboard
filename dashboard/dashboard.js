// dashboard.js
fetch('./assets/data/data.json')
  .then(response => response.json())
  .then(data => {
    window.customerData = data;
    // Bar Chart Setup (Dynamic from Data)
    const divisionChartCanvas = document.getElementById('divisionChart');
    if (divisionChartCanvas) {
      const ctx = divisionChartCanvas.getContext('2d');
      if (window.divisionChartInstance) window.divisionChartInstance.destroy();

      const divisionIncome = {};
      data.forEach(entry => {
        if (!divisionIncome[entry.Division]) {
          divisionIncome[entry.Division] = 0;
        }
        divisionIncome[entry.Division] += entry.Income;
      });

      const divisionLabels = Object.keys(divisionIncome);
      const divisionValues = Object.values(divisionIncome);

      window.divisionChartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: divisionLabels,
          datasets: [{
            label: 'Total Income by Division',
            data: divisionValues,
            backgroundColor: '#00d4ff',
            borderRadius: 8,
            barPercentage: 0.6,
            categoryPercentage: 0.5
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          animation: {
            duration: 1000,
            easing: 'easeOutCubic',
            delay: context => context.dataIndex * 150
          },
          plugins: {
            legend: {
              position: 'top',
              labels: {
                color: '#cfd6f6',
                boxWidth: 12,
                padding: 20
              }
            },
            tooltip: {
              callbacks: {
                label: (context) => `৳${context.raw.toLocaleString()}`
              },
              backgroundColor: '#1e2d4b',
              titleColor: '#ffffff',
              bodyColor: '#c0c9f0',
              borderColor: '#00d4ff',
              borderWidth: 1,
              padding: 10
            }
          },
          scales: {
            x: {
              ticks: { color: '#cfd6f6' },
              grid: { display: false }
            },
            y: {
              ticks: {
                color: '#cfd6f6',
                callback: value => `৳${value / 1000}k`
              },
              grid: { color: 'rgba(255, 255, 255, 0.05)' }
            }
          }
        }
      });
    }

    //Donut Chart Setup (Dynamic from Data) 
    const donutCanvas = document.getElementById('incomeDonut');
    if (donutCanvas) {
      const donutCtx = donutCanvas.getContext('2d');
      if (window.incomeDonutChartInstance) window.incomeDonutChartInstance.destroy();

      let low = 0, mid = 0, high = 0;
      data.forEach(entry => {
        if (entry.Income < 30000) low++;
        else if (entry.Income <= 70000) mid++;
        else high++;
      });

      window.incomeDonutChartInstance = new Chart(donutCtx, {
        type: 'doughnut',
        data: {
          labels: [
            `Low Income (${low})`,
            `Middle Income (${mid})`,
            `High Income (${high})`
          ],
          datasets: [{
            label: 'Customer Segments',
            data: [low, mid, high],
            backgroundColor: ['#f67280', '#74b9ff', '#55efc4'],
            borderWidth: 3,
            borderColor: '#0f172a',
            hoverOffset: 10
          }]
        },
        options: {
          responsive: true,
          cutout: '70%',
          plugins: {
            legend: {
              display: true,
              position: 'bottom',
              labels: {
                color: '#cfd6f6',
                usePointStyle: true,
                padding: 15,
                boxWidth: 12
              }
            },
            tooltip: {
              backgroundColor: '#1e2d4b',
              titleColor: '#ffffff',
              bodyColor: '#c0c9f0',
              borderColor: '#00d4ff',
              borderWidth: 1,
              padding: 10
            }
          },
          animation: {
            animateRotate: true,
            duration: 1200,
            easing: 'easeOutQuart'
          }
        }
      });
    }

    //Marital Status Stacked Bar Chart Setup
    const maritalCanvas = document.getElementById('maritalStatusChart');
    if (maritalCanvas) {
      const divisions = [...new Set(data.map(entry => entry.Division))];
      const maritalStatuses = ['Single', 'Married', 'Divorced'];

      const counts = {
        Single: Array(divisions.length).fill(0),
        Married: Array(divisions.length).fill(0),
        Divorced: Array(divisions.length).fill(0)
      };

      data.forEach(entry => {
        const divisionIndex = divisions.indexOf(entry.Division);
        if (divisionIndex !== -1 && counts[entry.MaritalStatus]) {
          counts[entry.MaritalStatus][divisionIndex]++;
        }
      });

      const datasets = maritalStatuses.map((status, index) => ({
        label: status,
        data: counts[status],
        backgroundColor: ['#ff7675', '#74b9ff', '#55efc4'][index],
        stack: 'maritalStack',
        borderRadius: 8
      }));

      new Chart(maritalCanvas.getContext('2d'), {
        type: 'bar',
        data: {
          labels: divisions,
          datasets: datasets
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'top',
              labels: {
                color: '#cfd6f6',
                usePointStyle: true,
                padding: 15,
                boxWidth: 12
              }
            },
            tooltip: {
              backgroundColor: '#1e2d4b',
              titleColor: '#ffffff',
              bodyColor: '#c0c9f0',
              borderColor: '#00d4ff',
              borderWidth: 1,
              padding: 10
            }
          },
          scales: {
            x: {
              stacked: true,
              ticks: { color: '#cfd6f6' },
              grid: { display: false }
            },
            y: {
              stacked: true,
              ticks: {
                color: '#cfd6f6',
                stepSize: 1
              },
              grid: { color: 'rgba(255, 255, 255, 0.05)' }
            }
          }
        }
      });
    }

    //Gender-based Income Pie Chart Setup
    const genderPieCanvas = document.getElementById('genderPieChart');
    if (genderPieCanvas) {
      const genderCtx = genderPieCanvas.getContext('2d');
      if (window.genderPieChartInstance) window.genderPieChartInstance.destroy();

      let maleIncome = 0, femaleIncome = 0;
      data.forEach(entry => {
        if (entry.Gender === 'M') maleIncome += entry.Income;
        else if (entry.Gender === 'F') femaleIncome += entry.Income;
      });

      window.genderPieChartInstance = new Chart(genderCtx, {
        type: 'pie',
        data: {
          labels: ['Male', 'Female'],
          datasets: [{
            data: [maleIncome, femaleIncome],
            backgroundColor: ['#81ecec', '#fab1a0'],
            borderColor: '#0f172a',
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                color: '#cfd6f6',
                usePointStyle: true,
                padding: 10,
                boxWidth: 12
              }
            },
            tooltip: {
              callbacks: {
                label: context => `৳${context.raw.toLocaleString()}`
              },
              backgroundColor: '#1e2d4b',
              titleColor: '#ffffff',
              bodyColor: '#c0c9f0',
              borderColor: '#00d4ff',
              borderWidth: 1,
              padding: 10
            }
          },
          animation: {
            duration: 1200,
            easing: 'easeOutQuart'
          }
        }
      });
    }

    //Age vs Income Line Chart Setup
    const ageIncomeCanvas = document.getElementById('ageIncomeChart');
    if (ageIncomeCanvas) {
      const ageBands = ['<25', '25-34', '35-44', '45-54', '55+'];
      const incomeByBand = Array(ageBands.length).fill(0);
      const countByBand = Array(ageBands.length).fill(0);

      data.forEach(entry => {
        let index = 0;
        if (entry.Age < 25) index = 0;
        else if (entry.Age < 35) index = 1;
        else if (entry.Age < 45) index = 2;
        else if (entry.Age < 55) index = 3;
        else index = 4;

        incomeByBand[index] += entry.Income;
        countByBand[index]++;
      });

      const averageIncome = incomeByBand.map((total, i) =>
        countByBand[i] > 0 ? Math.round(total / countByBand[i]) : 0
      );

      new Chart(ageIncomeCanvas.getContext('2d'), {
        type: 'line',
        data: {
          labels: ageBands,
          datasets: [{
            label: 'Avg Income by Age Group',
            data: averageIncome,
            borderColor: '#00cec9',
            backgroundColor: 'rgba(0, 206, 201, 0.3)',
            tension: 0.3,
            fill: true,
            pointRadius: 5,
            pointBackgroundColor: '#00cec9'
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'top',
              labels: { color: '#cfd6f6' }
            },
            tooltip: {
              callbacks: {
                label: context => `৳${context.raw.toLocaleString()}`
              },
              backgroundColor: '#1e2d4b',
              titleColor: '#ffffff',
              bodyColor: '#c0c9f0',
              borderColor: '#00d4ff',
              borderWidth: 1,
              padding: 10
            }
          },
          scales: {
            x: {
              ticks: { color: '#cfd6f6' },
              grid: { display: false }
            },
            y: {
              ticks: {
                color: '#cfd6f6',
                callback: value => `৳${value / 1000}k`
              },
              grid: { color: 'rgba(255, 255, 255, 0.05)' }
            }
          }
        }
      });
    }

    //Zero Income Chart and Count Setup
    const zeroIncomeCanvas = document.getElementById('zeroIncomeBar');
    const zeroIncomeCountEl = document.getElementById('zeroIncomeCount');
    if (zeroIncomeCanvas && zeroIncomeCountEl) {
      let zeroCount = 0;
      let withIncomeCount = 0;

      data.forEach(entry => {
        if (entry.Income === 0) zeroCount++;
        else withIncomeCount++;
      });

      zeroIncomeCountEl.textContent = zeroCount;

      new Chart(zeroIncomeCanvas.getContext('2d'), {
        type: 'bar',
        data: {
          labels: ['Zero Income', 'With Income'],
          datasets: [{
            data: [zeroCount, withIncomeCount],
            backgroundColor: ['#ff7675', '#00d4ff'],
            borderRadius: 10,
            barPercentage: 0.5,
            categoryPercentage: 0.6
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            tooltip: {
              backgroundColor: '#1e2d4b',
              titleColor: '#ffffff',
              bodyColor: '#c0c9f0',
              borderColor: '#00d4ff',
              borderWidth: 1,
              padding: 10
            }
          },
          scales: {
            x: {
              ticks: { color: '#cfd6f6' },
              grid: { display: false }
            },
            y: {
              ticks: {
                color: '#cfd6f6',
                stepSize: 5,
                precision: 0
              },
              grid: { color: 'rgba(255, 255, 255, 0.05)' }
            }
          }
        }
      });
    }

    //Customer Table Rendering
    const customerTableBody = document.querySelector('.customer-table-body');
    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');
    const nameSearchInput = document.getElementById('nameSearchInput');

    function renderCustomerTable(filteredData) {
      customerTableBody.innerHTML = '';
      const formatIncome = value => `৳${Number(value).toLocaleString()}`;
      const userRole = document.body.dataset.role;

      filteredData.forEach((entry, index) => {
        const row = document.createElement('div');
        row.classList.add('customer-row');
        row.style.animationDelay = `${index * 50}ms`;

        const incomePercent = Math.min((entry.Income / 100000) * 100, 100);

        let rowHTML = `
          <div>${entry["Customer Name"] || 'N/A'}</div>
          <div>${entry.Division}</div>
          <div>${entry.Gender === 'M' ? 'Male' : 'Female'}</div>
          <div>${entry.Age}</div>
          <div>${entry.MaritalStatus}</div>
          <div>
            <div class="progress-bar-container">
              <div class="progress-bar" style="width: ${incomePercent}%"></div>
            </div>
            <span style="font-size: 12px; color: #74b9ff;">${formatIncome(entry.Income)}</span>
          </div>
        `;

        // Admins see "Edit" buttons
        if (userRole === 'admin') {
          rowHTML += `<button class="edit-btn" data-id="${entry.ID}">Edit</button>`;
        }

        row.innerHTML = rowHTML;
        customerTableBody.appendChild(row);
      });
    }
    
    function applyFiltersAndSorting() {
      let filtered = [...data];

      const filterTerm = searchInput?.value.trim().toLowerCase();
      if (filterTerm) {
        filtered = filtered.filter(entry => {
          const gender = entry.Gender === 'M' ? 'male' : 'female';
          return (
            entry.Division?.toLowerCase().includes(filterTerm) ||
            gender === filterTerm ||
            entry.MaritalStatus?.toLowerCase().includes(filterTerm) ||
            entry.Income.toString().includes(filterTerm)
          );
        });
      }

      const nameTerm = nameSearchInput?.value.trim().toLowerCase();
      if (nameTerm) {
        filtered = filtered.filter(entry => entry["Customer Name"]?.toLowerCase().includes(nameTerm));
      }

      const sortBy = sortSelect?.value;
      if (sortBy === 'age') {
        filtered.sort((a, b) => a.Age - b.Age);
      } else if (sortBy === 'income') {
        filtered.sort((a, b) => b.Income - a.Income);
      }

      renderCustomerTable(filtered);
    }

    if (customerTableBody) {
      renderCustomerTable(data);
      searchInput?.addEventListener('input', applyFiltersAndSorting);
      sortSelect?.addEventListener('change', applyFiltersAndSorting);
      nameSearchInput?.addEventListener('input', applyFiltersAndSorting);

      const clearBtn = document.getElementById('clearFiltersBtn');
      clearBtn?.addEventListener('click', () => {
        searchInput.value = '';
        nameSearchInput.value = '';
        sortSelect.value = '';
        renderCustomerTable(data);
      });
    }
    // Overview DOM Refs
    // Add Notification Icon
    const searchLoginContainer = document.querySelector('.search-login');
    const profileBtn = document.querySelector('.profile-button');

    if (searchLoginContainer && profileBtn) {
      const notifBtn = document.createElement('button');
      notifBtn.className = 'notif-btn';
      notifBtn.innerHTML = '<i class="fas fa-bell"></i>';
      notifBtn.style.margin = '0 10px';
      notifBtn.style.background = '#2a3558';
      notifBtn.style.border = 'none';
      notifBtn.style.padding = '8px';
      notifBtn.style.borderRadius = '6px';
      notifBtn.style.cursor = 'pointer';
      notifBtn.style.color = '#cfd6f6';
      notifBtn.title = 'Notifications';

      searchLoginContainer.insertBefore(notifBtn, profileBtn);
    }
  })

  .catch(error => console.error('Error loading or parsing data.json:', error));


// =======================
// ✨ Edit Button Logic
// =======================
document.addEventListener('click', function (e) {
  if (e.target.classList.contains('edit-btn')) {
    const customerId = e.target.getAttribute('data-id');
    const customer = window.customerData.find(c => c.ID === customerId);
    if (!customer) return;

    // Fill modal form fields
    document.getElementById('editCustomerId').value = customer.ID;
    document.getElementById('editName').value = customer["Customer Name"];
    document.getElementById('editDivision').value = customer.Division;
    document.getElementById('editGender').value = 
      customer.Gender === 'M' ? 'Male' : (customer.Gender === 'F' ? 'Female' : 'Other');
    document.getElementById('editAge').value = customer.Age;
    document.getElementById('editMarital').value = customer.MaritalStatus;
    document.getElementById('editIncome').value = customer.Income;

    // Show modal
    document.getElementById('editModal').classList.remove('hidden');
  }
});

// Close modal on Escape or outside click (optional)
document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape') {
    document.getElementById('editModal').classList.add('hidden');
  }
});

document.addEventListener('click', function (e) {
  if (e.target.id === 'editModal') {
    document.getElementById('editModal').classList.add('hidden');
  }
});

// =======================
// ✅ AJAX Submission with Toast Notification
// =======================
document.getElementById('editForm')?.addEventListener('submit', function (e) {
  e.preventDefault(); // Stop form from reloading page

  const formData = new FormData(this);

  fetch('submit_edit.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(response => {
    if (response.trim() === 'success') {
      showToast("✅ Edit request submitted for manager approval.");
      document.getElementById('editModal').classList.add('hidden');
      this.reset();
    } else {
      showToast("⚠️ Failed to submit: " + response);
    }
  })
  .catch(error => {
    console.error('Submit Error:', error);
    showToast("❌ Submission failed. Please try again.");
  });
});

// =======================
// 🔔 showToast Utility Function
// =======================
function showToast(message) {
  const toast = document.createElement('div');
  toast.textContent = message;
  toast.style.position = 'fixed';
  toast.style.bottom = '30px';
  toast.style.right = '30px';
  toast.style.background = '#2a3558';
  toast.style.color = '#cfd6f6';
  toast.style.padding = '12px 20px';
  toast.style.borderRadius = '8px';
  toast.style.boxShadow = '0 4px 12px rgba(0,0,0,0.3)';
  toast.style.zIndex = '9999';
  toast.style.transition = 'opacity 0.4s ease';
  toast.style.opacity = '1';

  document.body.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = '0';
    setTimeout(() => document.body.removeChild(toast), 500);
  }, 3000);
}

// =======================
// 🔔 Notification Icon & Dropdown
// =======================
document.addEventListener("DOMContentLoaded", () => {
  const notifBtn = document.querySelector(".notif-btn");
  const notifDropdown = document.querySelector(".notif-dropdown");
  const notifCount = document.getElementById("notifCount");
  const notifList = document.getElementById("notifList");

  async function loadNotifications() {
    const res = await fetch("fetch_notifications.php");
    const data = await res.json();

    if (data.length > 0) {
      notifCount.style.display = "inline-block";
      notifCount.textContent = data.length;
      notifDropdown.style.display = "none";

      notifList.innerHTML = "";
      data.forEach(n => {
        const li = document.createElement("li");
        li.innerHTML = `${n.message} <br><a href="${n.link}">Review</a>`;
        notifList.appendChild(li);
      });
    } else {
      notifCount.style.display = "none";
      notifDropdown.style.display = "none";
    }
  }

  notifBtn.addEventListener("click", () => {
    notifDropdown.style.display =
      notifDropdown.style.display === "none" ? "block" : "none";
  });

  document.addEventListener("click", (e) => {
    if (!notifBtn.contains(e.target) && !notifDropdown.contains(e.target)) {
      notifDropdown.style.display = "none";
    }
  });

  loadNotifications();
});
