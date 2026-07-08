<style>

.footer-dashboard{

    margin-top:40px;

    background:#FFFFFF;

    border-top:1px solid #E5E7EB;

    padding:18px 30px;

}

.footer-content{

    display:flex;

    justify-content:space-between;

    align-items:center;

    flex-wrap:wrap;

    gap:15px;

}

.footer-left{

    display:flex;

    align-items:center;

    gap:12px;

    color:#64748B;

    font-size:14px;

}

.footer-right{

    display:flex;

    align-items:center;

    gap:18px;

    color:#64748B;

    font-size:14px;

}

.version-badge{

    background:#EEF2FF;

    color:#4F46E5;

    padding:4px 12px;

    border-radius:30px;

    font-size:12px;

    font-weight:600;

}

.status-online{

    display:flex;

    align-items:center;

    gap:8px;

}

.status-online::before{

    content:"";

    width:10px;

    height:10px;

    border-radius:50%;

    background:#10B981;

    display:inline-block;

}

@media(max-width:768px){

.footer-content{

flex-direction:column;

align-items:flex-start;

}

.footer-right{

flex-wrap:wrap;

}

}

</style>

<footer class="footer-dashboard">

    <div class="footer-content">

        <div class="footer-left">

            <strong>DonasiKu Foundation</strong>

            <span>

                © <?= date('Y') ?>

            </span>

            <span>

                All Rights Reserved

            </span>

        </div>

        <div class="footer-right">

            <div class="status-online">

                System Online

            </div>

            <span class="version-badge">

                Version 1.0.0

            </span>

            <span>

                Built with ❤️ CodeIgniter 4

            </span>

        </div>

    </div>

</footer>