
document.addEventListener("DOMContentLoaded",function(){

    // ===============================
    // Data Chart
    // ===============================

    const campaignData = <?php json_encode($chartData) ?>;

    const categories = campaignData.map(item => item.judul);

    const totals = campaignData.map(item => Number(item.dana_terkumpul));

    const options = {

        chart:{

            type:'bar',

            height:340,

            toolbar:{
                show:false
            }

        },

        series:[{

            name:'Dana',

            data:totals

        }],

        xaxis:{

            categories:categories

        },

        colors:['#6366F1'],

        dataLabels:{
            enabled:false
        },

        stroke:{
            show:true,
            width:2
        },

        grid:{
            borderColor:'#E2E8F0'
        },

        plotOptions:{

            bar:{

                borderRadius:10,

                columnWidth:'45%'

            }

        },

        yaxis:{

            labels:{

                formatter:function(value){

                    return 'Rp ' + value.toLocaleString('id-ID');

                }

            }

        },

        tooltip:{

            y:{

                formatter:function(value){

                    return 'Rp ' + value.toLocaleString('id-ID');

                }

            }

        }

    };

    new ApexCharts(
        document.querySelector("#donationChart"),
        options
    ).render();



    // ===============================
    // Animasi Card
    // ===============================

    const cards = document.querySelectorAll('.stat-card,.card-dashboard');

    cards.forEach((card,index)=>{

        card.style.opacity="0";

        card.style.transform="translateY(30px)";

        setTimeout(()=>{

            card.style.transition=".6s";

            card.style.opacity="1";

            card.style.transform="translateY(0)";

        },index*120);

    });

});
