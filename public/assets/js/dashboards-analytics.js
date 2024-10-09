/**
 * Dashboard Analytics
 */

'use strict';

(function () {
  let cardColor, labelColor, borderColor, chartBgColor, bodyColor;

  cardColor = config.colors.cardColor;
  labelColor = config.colors.textMuted;
  borderColor = config.colors.borderColor;
  chartBgColor = config.colors.chartBgColor;
  bodyColor = config.colors.bodyColor;

  document.addEventListener('DOMContentLoaded', function() {
    const options = {
        chart: {
            height: 200,
            type: 'line',
            parentHeightOffset: 0,
            toolbar: {
              show: true
            }
          },
          grid: {
            borderColor: labelColor,
            strokeDashArray: 6,
            xaxis: {
              lines: {
                show: true
              }
            },
            yaxis: {
              lines: {
                show: true
              }
            },
            padding: {
              top: -15,
              left: -7,
              right: 9,
              bottom: 0
            }
          },
          colors: [config.colors.warning, config.colors.primary],
          stroke: {
            width: 3,
            curve: 'smooth'
          },
          series: [
            {
                name: 'Sebelum Revisi', // Name for the first data series
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            },
            {
                name: 'Setelah Revisi', // Name for the second data series
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            }
          ],
          tooltip: {
            enabled: true,
            shared: false,
            // intersect: true,
            y: {
                formatter: function (val) {
                    return val
                }
            }
          },
          xaxis: {
            categories: ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'E'],
            labels: {
              show: true
            },
            axisTicks: {
              show: false
            },
            axisBorder: {
              show: false
            }
          },
          yaxis: {
            // categories: ['0', '2', '4', '6', '8', '10'],
            labels: {
              show: true
            }
          },
          responsive: [
            {
              breakpoint: 1350,
              options: {
                chart: {
                  height: 190
                }
              }
            },
            {
              breakpoint: 1200,
              options: {
                chart: {
                  height: 210
                }
              }
            },
            {
              breakpoint: 768,
              options: {
                chart: {
                  height: 220
                }
              }
            }
          ]
    };

    // Initialize the chart instance
    const totalProfitLineChart = new ApexCharts(document.querySelector("#totalProfitLineChart"), options);

    // Render the chart
    totalProfitLineChart.render();

    // Default category (first value of dropdown)
    let defaultCategory = document.querySelector('#kategoriList .dropdown-item').getAttribute('data-kategori');
    loadChartData(defaultCategory);

    document.querySelectorAll('#kategoriList .dropdown-item').forEach(function(item) {
        item.addEventListener('click', function() {
            const selectedCategory = this.getAttribute('data-kategori');
            document.getElementById('dropdown-status-label').innerText = selectedCategory;
            loadChartData(selectedCategory);
        });
    });

    // Function to load chart data
    function loadChartData(category) {
        fetch(`/get-chart-data/${category}`)
            .then(response => response.json())
            .then(data => {
                updateChart(data);
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    // // Initialize the chart instance
    // const chart = new ApexCharts(document.querySelector("#chart"), options);

    // // Render the chart
    // chart.render();

    // Function to update chart data
    function updateChart(data) {
        // Initialize arrays to store counts
        const sebelumRevisi = [];
        const setelahRevisi = [];

        // Check if data is an object
        if (typeof data === 'object' && !Array.isArray(data)) {
            // Iterate over each category in the data
            Object.keys(data).forEach(category => {
                const categoryData = data[category];

                // Extract counts from each category
                const nilaiAwalCounts = categoryData.jumlah.map(item => item.nilai_awal_count);
                const revisiHodCounts = categoryData.jumlah.map(item => item.revisi_hod_count);

                // Aggregate or process the counts as needed
                sebelumRevisi.push(...nilaiAwalCounts);
                setelahRevisi.push(...revisiHodCounts);
            });

            // Update chart series
            totalProfitLineChart.updateSeries([
                {
                    name: 'Sebelum Revisi',
                    data: sebelumRevisi
                },
                {
                    name: 'Setelah Revisi',
                    data: setelahRevisi
                }
            ]);
        } else {
            console.error('Unexpected data format:', data);
        }
    }

  });

  // Total Profit line chart
  // --------------------------------------------------------------------
//   const totalProfitLineChartEl = document.querySelector('#totalProfitLineChart'),
//     totalProfitLineChartConfig = {
//       chart: {
//         height: 200,
//         type: 'line',
//         parentHeightOffset: 0,
//         toolbar: {
//           show: true
//         }
//       },
//       grid: {
//         borderColor: labelColor,
//         strokeDashArray: 6,
//         xaxis: {
//           lines: {
//             show: true
//           }
//         },
//         yaxis: {
//           lines: {
//             show: true
//           }
//         },
//         padding: {
//           top: -15,
//           left: -7,
//           right: 9,
//           bottom: 0
//         }
//       },
//       colors: [config.colors.warning, config.colors.primary],
//       stroke: {
//         width: 3,
//         curve: 'smooth'
//       },
//       series: [
//         {
//             name: 'Sebelum Revisi', // Name for the first data series
//             data: [0, 0, 0, 0, 3, 0, 0, 2, 0, 0, 3, 0, 0]
//         },
//         {
//             name: 'Setelah Revisi', // Name for the second data series
//             data: [0, 0, 0, 1, 2, 2, 0, 3, 0, 0, 0, 0, 0]
//         }
//       ],
//       tooltip: {
//         enabled: true,
//         shared: false,
//         // intersect: true,
//         y: {
//             formatter: function (val) {
//                 return val
//             }
//         }
//       },
//       xaxis: {
//         categories: ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'E'],
//         labels: {
//           show: true
//         },
//         axisTicks: {
//           show: false
//         },
//         axisBorder: {
//           show: false
//         }
//       },
//       yaxis: {
//         // categories: ['0', '2', '4', '6', '8', '10'],
//         labels: {
//           show: true
//         }
//       },
//       responsive: [
//         {
//           breakpoint: 1350,
//           options: {
//             chart: {
//               height: 190
//             }
//           }
//         },
//         {
//           breakpoint: 1200,
//           options: {
//             chart: {
//               height: 210
//             }
//           }
//         },
//         {
//           breakpoint: 768,
//           options: {
//             chart: {
//               height: 220
//             }
//           }
//         }
//       ]
//     };
//   if (typeof totalProfitLineChartEl !== undefined && totalProfitLineChartEl !== null) {
//     const totalProfitLineChart = new ApexCharts(totalProfitLineChartEl, totalProfitLineChartConfig);
//     totalProfitLineChart.render();
//   }


})();
