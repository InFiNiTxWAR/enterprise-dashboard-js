const ctx = document.getElementById('relatorioChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
        datasets: [{
            label: 'Faturamento (R$)',
            data: [12000, 19000, 15000, 22000, 28000, 35000],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true
            }
        }
    }
});