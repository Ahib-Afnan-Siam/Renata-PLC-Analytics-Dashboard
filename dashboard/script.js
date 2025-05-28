// Highlight Sidebar Navigation
const highlightBox = document.getElementById('highlightBox');
const navItems = document.querySelectorAll('#navItems li');
const accountItems = document.querySelectorAll('#accountItems li');
const allItems = [...navItems, ...accountItems];

const spacing = 40;
const baseOffset = 76;
const navCount = navItems.length;
const accountStartOffset = baseOffset + navCount * spacing + 32;

allItems.forEach((item, index) => {
  item.addEventListener('click', () => {
    allItems.forEach(el => el.classList.remove('active'));
    item.classList.add('active');

    const offset = index < navCount
      ? baseOffset + index * spacing
      : accountStartOffset + (index - navCount) * spacing;

    highlightBox.style.top = `${offset}px`;
  });
});

// On DOM Ready
window.addEventListener('DOMContentLoaded', () => {
  fadeInElements();
  loadMetrics();
  loadTopCustomers();
});

function fadeInElements() {
  const fadeItems = document.querySelectorAll('.card, .welcome-card, .revenue-card, .top-customers-card');
  fadeItems.forEach((el, index) => {
    el.style.opacity = 0;
    el.style.transform = 'translateY(20px)';
    el.style.transition = `opacity 0.6s ${index * 0.1}s ease-out, transform 0.6s ${index * 0.1}s ease-out`;
    requestAnimationFrame(() => {
      el.style.opacity = 1;
      el.style.transform = 'translateY(0)';
    });
  });
}

function animateValue(id, end, duration = 1500) {
  const el = document.getElementById(id);
  if (!el) return;

  let start = 0;
  const range = end - start;
  let startTime = null;

  function step(timestamp) {
    if (!startTime) startTime = timestamp;
    const progress = timestamp - startTime;
    const percent = Math.min(progress / duration, 1);
    const value = Math.floor(percent * range);

    el.innerHTML = (id === 'averageIncome' || id === 'highestIncome')
      ? `৳${value.toLocaleString()}`
      : id === 'totalRevenue'
      ? `<span class="currency">৳</span>${value.toLocaleString()}`
      : value;

    if (percent < 1) requestAnimationFrame(step);
  }

  requestAnimationFrame(step);
}

async function loadMetrics() {
  const response = await fetch('./assets/data/data.json');
  const data = await response.json();

  const totalCustomers = data.length;
  const incomes = data.map(item => item.Income);
  const validIncomes = incomes.filter(i => i > 0);
  const avgIncome = validIncomes.reduce((a, b) => a + b, 0) / validIncomes.length;
  const highestIncome = Math.max(...validIncomes);

  const divisionCounts = {};
  data.forEach(item => {
    divisionCounts[item.Division] = (divisionCounts[item.Division] || 0) + 1;
  });

  animateValue('totalCustomers', totalCustomers);
  animateValue('averageIncome', Math.round(avgIncome));
  animateValue('highestIncome', highestIncome);
  animateValue('divisionCount', Object.keys(divisionCounts).length);

  const totalSales = data.reduce((sum, item) => sum + item.Income, 0);
  animateValue('totalRevenue', totalSales);
}

async function loadTopCustomers() {
  try {
    const response = await fetch('./assets/data/data.json');
    const data = await response.json();

    const top5 = data
      .filter(item => item.Income && item.Income > 0)
      .sort((a, b) => b.Income - a.Income)
      .slice(0, 5);

    const list = document.getElementById('topCustomersList');
    list.innerHTML = '';

    top5.forEach((customer, index) => {
      const item = document.createElement('li');
      item.classList.add('top-customer-item');

      const rankIcon = index === 0 ? '<span class="badge gold">🥇</span>'
                      : index === 1 ? '<span class="badge silver">🥈</span>'
                      : index === 2 ? '<span class="badge bronze">🥉</span>'
                      : `<span class="badge">#${index + 1}</span>`;

      item.innerHTML = `
        ${rankIcon}
        <span class="name"><strong>${customer["Customer Name"]}</strong></span>
        <span class="amount">৳${customer.Income.toLocaleString()}</span>
      `;

      item.style.opacity = 0;
      item.style.transform = 'translateY(20px)';
      item.style.transition = `opacity 0.6s ${index * 0.1}s ease-out, transform 0.6s ${index * 0.1}s ease-out`;

      list.appendChild(item);

      requestAnimationFrame(() => {
        item.style.opacity = 1;
        item.style.transform = 'translateY(0)';
      });
    });
  } catch (err) {
    console.error('Error loading top customers:', err);
  }
}
