fetch('api.php')
    .then(response => response.json())
    .then(data => {

        // grafico de linha
        new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: {
               labels: data.labels,
                datasets: [{
                    label: 'Vendas (R$)',
                    data: data.vendasMensais,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    tension: 0.4,
                    fill: true
                }]
            }
        });

        // grafico de pizza
        new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: Object.keys(data.produtos),
                datasets: [{
                    data: Object.values(data.produtos),
                    backgroundColor: [
                        '#3b82f6',
                        '#10b981',
                        '#f59e0b',
                        '#ef4444'
                    ]
                }]
            }
        });

// graffico de barras
        new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: ['2021', '2022', '2023', '2024'],
                datasets: [{
                    label: 'Faturamento (R$)',
                    data: data.comparativoAnual,
                    backgroundColor: '#6366f1'
                }]
            }
        });

    })
    .catch(error => console.error('Erro ao carregar dados:', error));