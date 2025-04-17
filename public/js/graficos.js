document.addEventListener('DOMContentLoaded', function() {
    // Inicializar Flatpickr para el selector de fechas
    flatpickr("#datepicker-range-start", {
        dateFormat: "Y-m-d",
        defaultDate: "{{ request('start_date') ? request('start_date') : 'today' }}",
    });
    flatpickr("#datepicker-range-end", {
        dateFormat: "Y-m-d",
        defaultDate: "{{ request('end_date') ? request('end_date') : 'today' }}",
    });

    // Datos para el gráfico de total de combustible por día
    var combustibleData = @json($combustiblePorDia);
    var fechasCombustible = combustibleData.map(item => item.fecha);
    var totalCombustible = combustibleData.map(item => item.total_combustible);

    var opcionesCombustible = {
        chart: {
            type: 'bar',
           
        },
        plotOptions: {
            bar: {
                distributed: true
            }
        },
        series: [{
            name: 'Total Combustible',
            data: totalCombustible
        }],
        xaxis: {
            categories: fechasCombustible,
            title: {
                text: 'Fecha'
            },
            labels: {
                style: {
                    colors: [], // Se actualizarán según el tema
                }
            }
        },
        yaxis: {
            title: {
                text: 'Cantidad de Combustible'
            },
            labels: {
                style: {
                    colors: [], // Se actualizarán según el tema
                }
            }
        },
        title: {
            text: 'Total de Combustible por Día',
            style: {
                color: '' // Se actualizará según el tema
            }
        }
    };

    var chartCombustible = new ApexCharts(document.querySelector("#graficoCombustible"), opcionesCombustible);
    chartCombustible.render();

    // Datos para el gráfico de total de órdenes por día
    var ordenesData = @json($ordenesPorDia);
    var fechasOrdenes = ordenesData.map(item => item.fecha);
    var totalOrdenes = ordenesData.map(item => item.total_ordenes);

    var opcionesOrdenes = {
        chart: {
            type: 'bar'
        },
        plotOptions: {
            bar: {
                distributed: true
            }
        },
        series: [{
            name: 'Total Órdenes',
            data: totalOrdenes
        }],
        xaxis: {
            categories: fechasOrdenes,
            title: {
                text: 'Fecha'
            },
            labels: {
                style: {
                    colors: [], // Se actualizarán según el tema
                }
            }
        },
        yaxis: {
            title: {
                text: 'Número de Órdenes'
            },
            labels: {
                style: {
                    colors: [], // Se actualizarán según el tema
                }
            }
        },
        title: {
            text: 'Total de Órdenes por Día',
            style: {
                color: '' // Se actualizará según el tema
            }
        }
    };

    var chartOrdenes = new ApexCharts(document.querySelector("#graficoOrdenes"), opcionesOrdenes);
    chartOrdenes.render();

    function updateChartColors(theme) {
        var textColor = theme === 'dark' ? '#fdfefe' : '#17202a';

        // Actualiza el color de los textos y etiquetas para el gráfico de combustible
        chartCombustible.updateOptions({
            xaxis: {
                labels: {
                    style: {
                        colors: [textColor]
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: [textColor]
                    }
                }
            },
            title: {
                style: {
                    color: textColor
                }
            }
        });

        // Actualiza el color de los textos y etiquetas para el gráfico de órdenes
        chartOrdenes.updateOptions({
            xaxis: {
                labels: {
                    style: {
                        colors: [textColor]
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: [textColor]
                    }
                }
            },
            title: {
                style: {
                    color: textColor
                }
            }
        });
    }

    // Obtén el tema actual y actualiza los gráficos
    var currentTheme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
    updateChartColors(currentTheme);
});