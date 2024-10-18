/**
 * Dashboard Analytics
 */

"use strict";

(function () {
    let cardColor, labelColor, borderColor, chartBgColor, bodyColor;

    cardColor = config.colors.cardColor;
    labelColor = config.colors.textMuted;
    borderColor = config.colors.borderColor;
    chartBgColor = config.colors.chartBgColor;
    bodyColor = config.colors.bodyColor;

    document.addEventListener("DOMContentLoaded", function () {
        const options = {
            chart: {
                height: 200,
                type: "line",
                parentHeightOffset: 0,
                toolbar: {
                    show: true,
                },
            },
            grid: {
                borderColor: labelColor,
                strokeDashArray: 6,
                xaxis: {
                    lines: {
                        show: true,
                    },
                },
                yaxis: {
                    lines: {
                        show: true,
                    },
                },
                padding: {
                    top: -15,
                    left: -7,
                    right: 9,
                    bottom: 0,
                },
            },
            colors: [config.colors.warning, config.colors.primary],
            stroke: {
                width: 3,
                curve: "smooth",
            },
            series: [
                {
                    name: "Sebelum Revisi", // Name for the first data series
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                },
                {
                    name: "Setelah Revisi", // Name for the second data series
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                },
            ],
            tooltip: {
                enabled: true,
                shared: false,
                // intersect: true,
                y: {
                    formatter: function (val) {
                        return val;
                    },
                },
            },
            xaxis: {
                categories: [
                    "A+",
                    "A",
                    "A-",
                    "B+",
                    "B",
                    "B-",
                    "C+",
                    "C",
                    "C-",
                    "D+",
                    "D",
                    "D-",
                    "E",
                ],
                labels: {
                    show: true,
                },
                axisTicks: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                },
            },
            yaxis: {
                // categories: ['0', '2', '4', '6', '8', '10'],
                labels: {
                    show: true,
                },
            },
            responsive: [
                {
                    breakpoint: 1350,
                    options: {
                        chart: {
                            height: 190,
                        },
                    },
                },
                {
                    breakpoint: 1200,
                    options: {
                        chart: {
                            height: 210,
                        },
                    },
                },
                {
                    breakpoint: 768,
                    options: {
                        chart: {
                            height: 220,
                        },
                    },
                },
            ],
        };

        // Initialize the chart instance
        const totalProfitLineChart = new ApexCharts(
            document.querySelector("#totalProfitLineChart"),
            options
        );

        // Render the chart
        totalProfitLineChart.render();

        // Default category (first value of dropdown)
        let defaultCategory = document
            .querySelector("#kategoriList .dropdown-item")
            .getAttribute("data-kategori");
        loadChartData(defaultCategory);

        document
            .querySelectorAll("#kategoriList .dropdown-item")
            .forEach(function (item) {
                item.addEventListener("click", function () {
                    const selectedCategory =
                        this.getAttribute("data-kategori");
                    document.getElementById("dropdown-status-label").innerText =
                        selectedCategory == "null" ? "Semua" : selectedCategory;
                    loadChartData(selectedCategory);
                });
            });

        // Function to load chart data
        function loadChartData(category) {
            console.log("category: " + category);
            fetch(`/get-chart-data/${category}`)
                .then((response) => response.json())
                .then((data) => {
                    updateChart(data, category);
                })
                .catch((error) => console.error("Error fetching data:", error));
        }

        // Function to update chart data
        function updateChart(data, category) {
            // Initialize arrays to store counts
            let sebelumRevisi = [];
            let setelahRevisi = [];

            if (typeof data === "object" && !Array.isArray(data)) {
                if (category === 'null') {
                    // Case for "All" categories
                    // Initialize an object to store the sum of counts at each index
                    const totalSebelumRevisi = {};
                    const totalSetelahRevisi = {};

                    // Iterate over each category in the data
                    Object.keys(data).forEach((cat) => {
                        const categoryData = data[cat];

                        // Extract counts from each category
                        categoryData.jumlah.forEach((item, index) => {
                            // Summing nilai_awal_count
                            if (!totalSebelumRevisi[index]) {
                                totalSebelumRevisi[index] = 0;
                            }
                            totalSebelumRevisi[index] += item.nilai_awal_count;

                            // Summing revisi_hod_count
                            if (!totalSetelahRevisi[index]) {
                                totalSetelahRevisi[index] = 0;
                            }
                            totalSetelahRevisi[index] += item.revisi_hod_count;
                        });
                    });

                    // Convert the summed counts into arrays
                    sebelumRevisi = Object.values(totalSebelumRevisi);
                    setelahRevisi = Object.values(totalSetelahRevisi);
                } else {
                    // Case for a specific category
                    const categoryData = data[category];

                    // Extract counts from the selected category
                    sebelumRevisi = categoryData.jumlah.map(
                        (item) => item.nilai_awal_count
                    );
                    setelahRevisi = categoryData.jumlah.map(
                        (item) => item.revisi_hod_count
                    );
                }

                // Log the results for debugging
                console.log("sebelumRevisi: " + sebelumRevisi);
                console.log("setelahRevisi: " + setelahRevisi);

                // Update chart series
                totalProfitLineChart.updateSeries([
                    {
                        name: "Sebelum Revisi",
                        data: sebelumRevisi,
                    },
                    {
                        name: "Setelah Revisi",
                        data: setelahRevisi,
                    },
                ]);
            } else {
                console.error("Unexpected data format:", data);
            }
        }
    });
})();
