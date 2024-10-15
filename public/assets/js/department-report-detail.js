/**
 * Dashboard Summary
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

    //Table Sort
    const table = document.querySelector('.table');
    const headers = table.querySelectorAll('thead th');

    headers.forEach((header, index) => {
        header.addEventListener('click', () => {
            // Determine the current sorting direction
            const isAscending = header.classList.contains('asc');

            // Remove sorting classes from all headers
            headers.forEach(th => th.classList.remove('asc', 'desc'));

            // Add the appropriate class to the clicked header
            header.classList.add(isAscending ? 'desc' : 'asc');

            // Sort rows
            const rows = Array.from(table.querySelectorAll('tbody tr'));
            const sortedRows = rows.sort((a, b) => {
                const aText = a.children[index].textContent.trim();
                const bText = b.children[index].textContent.trim();

                // Check if content is numeric
                const aValue = isNaN(aText) ? aText : parseFloat(aText);
                const bValue = isNaN(bText) ? bText : parseFloat(bText);

                return isAscending
                ? (aValue > bValue ? -1 : 1)  // Descending sort
                : (aValue < bValue ? -1 : 1); // Ascending sort
            });

            // Update table with sorted rows
            const tbody = table.querySelector('tbody');
            tbody.innerHTML = ''; // Clear existing rows
            tbody.append(...sortedRows); // Append sorted rows
        });
    });


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
                name: 'year1', // Name for the first data series
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            },
            {
                name: 'year2', // Name for the second data series
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
    let defaultYear = document.querySelector('#tahunDropdown .dropdown-item').getAttribute('data-tahun');
    let company = document.getElementById('company').getAttribute('data-value');
    let department = document.getElementById('department').getAttribute('data-value');
    loadChartData(company, department, defaultYear);

    document.querySelectorAll('#tahunDropdown .dropdown-item').forEach(function(item) {
        item.addEventListener('click', function() {
            const selectedYear = this.getAttribute('data-tahun');
            document.getElementById('dropdown-status-label').innerText = selectedYear;
            loadChartData(company, department, selectedYear);

            // Send an AJAX request to fetch data for the selected year
            fetch(`/get-chart-data-department/${company}/${department}/${selectedYear}`)
            .then(response => response.json()) // Convert response to JSON
            .then(data => {
                // Assuming 'data' contains the new chartData
                console.log(data);
                updateTableYear(data);
            })
            .catch(error => console.error('Error fetching data:', error));

        });
    });

    function updateTableYear(data) {
        data = data.data;
        if (!data || !data) {
            console.error('No data provided or data format is incorrect.');
            return; // Exit if data is undefined or null
        }

        // Clear existing rows in the table, if needed
        const tableBody = document.querySelector('#tableYear'); // Update with your table body ID
        tableBody.innerHTML = ''; // Clear existing content

        // Loop through the years and create rows for each year
        Object.keys(data).forEach(year => {
            const scores = data[year];
            const row = document.createElement('tr');
            const yearCell = document.createElement('th');

            yearCell.scope = "row"; // Set scope for the header cell
            yearCell.innerText = year; // Set the year text
            row.appendChild(yearCell); // Append year cell to the row

            let total = 0; // Initialize total for the current year

            // Loop through the scores for this year
            Object.keys(scores).forEach(score => {
                const count = scores[score];
                const scoreCell = document.createElement('td');
                scoreCell.innerText = count; // Set the score count
                row.appendChild(scoreCell); // Append score cell to the row

                total += count; // Update the total
            });

            // Add total cell for this row
            const totalCell = document.createElement('td');
            totalCell.innerText = total; // Set the total count
            row.appendChild(totalCell); // Append total cell to the row

            // Append the row to the table body
            tableBody.appendChild(row);
        });

        // Row for 'Jumlah'
        const totalRow = document.createElement('tr');
        const jumlahCell = document.createElement('th');
        jumlahCell.scope = "row";
        jumlahCell.innerText = "Jumlah"; // Set the 'Jumlah' label
        totalRow.appendChild(jumlahCell); // Append 'Jumlah' cell to total row

        const grandTotal = Object.keys(data).reduce((acc, year) => {
            const scores = data[year];
            // Sum all scores for 'Jumlah' row
            return acc + Object.values(scores).reduce((sum, count) => sum + count, 0);
        }, 0);

        // Loop through the scores to create the 'Jumlah' row
        Object.keys(data[Object.keys(data)[0]]).forEach(score => {
            const columnTotal = Object.keys(data).reduce((sum, year) => {
                return sum + (data[year][score] || 0); // Sum across all years for each score
            }, 0);

            const totalCell = document.createElement('td');
            totalCell.innerText = columnTotal; // Set the column total for this score
            totalRow.appendChild(totalCell); // Append to total row
        });

        // Total for all scores
        const grandTotalCell = document.createElement('td');
        grandTotalCell.innerText = grandTotal; // Set the grand total count
        totalRow.appendChild(grandTotalCell); // Append grand total cell to total row

        // Append the 'Jumlah' row to the table body
        tableBody.appendChild(totalRow);
    }

    // Function to load chart data
    function loadChartData(company, department, year) {
        fetch(`/get-chart-data-department/${company}/${department}/${year}`)
            .then(response => response.json())
            .then(data => {
                updateChart(data);
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    // Function to update chart data
    function updateChart(data) {

        // console.log(data['years']);
        const years = data['years'];
        const chartData = data['data'];

        // Initialize arrays to store counts
        const year0Datas = [];
        const year1Datas = [];

        // Check if data is an object
        if (typeof chartData === 'object' && !Array.isArray(chartData)) {
                // const categoryData = data[category];

                const year0Data = chartData[years[0]] || {};
                const year1Data = chartData[years[1]] || {};

                // Extract counts from each category
                Object.entries(year0Data).forEach(([score, year0Count]) => {
                    // Get the corresponding count from year2Data, defaulting to 0 if not present
                    const year1Count = year1Data[score] || 0;

                    // Push the counts to the respective arrays
                    year0Datas.push(year0Count);
                    year1Datas.push(year1Count);
                });
            // Update chart series
            totalProfitLineChart.updateSeries([
                {
                    name: years[0],
                    data: year0Datas
                },
                {
                    name: years[1],
                    data: year1Datas
                }
            ]);
        } else {
            console.error('Unexpected data format:', data);
        }
    }

  });
})();
