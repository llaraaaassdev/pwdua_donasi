<?php

$foundationName = session()->get('nama_yayasan') ?? session()->get('nama') ?? 'Yayasan';

?>

<style>

.topbar-left{
    display:flex;
    align-items:center;
    gap:15px;
}

.menu-toggle{

    width:42px;
    height:42px;

    border:none;

    background:#EEF2FF;

    color:#4F46E5;

    border-radius:12px;

    display:none;

}

.page-title{

    font-size:22px;

    font-weight:700;

    color:#0F172A;

    margin:0;

}

.page-subtitle{

    color:#64748B;

    font-size:14px;

}

.topbar-right{

    display:flex;

    align-items:center;

    gap:18px;

}

.notification{

    position:relative;

    width:45px;

    height:45px;

    border-radius:14px;

    background:#F8FAFC;

    display:flex;

    justify-content:center;

    align-items:center;

    cursor:pointer;

    transition:.3s;

}

.notification:hover{

    background:#EEF2FF;

}

.notification i{

    font-size:20px;

    color:#475569;

}

.notification-badge{

    position:absolute;

    top:8px;

    right:10px;

    width:8px;

    height:8px;

    border-radius:50%;

    background:#EF4444;

}

.profile-button{

    border:none;

    background:white;

    display:flex;

    align-items:center;

    gap:12px;

}

.avatar{

    width:45px;

    height:45px;

    border-radius:50%;

    background:#4F46E5;

    color:white;

    font-weight:bold;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:18px;

}

.profile-name{

    font-weight:600;

    color:#0F172A;

    font-size:15px;

}

.profile-role{

    font-size:12px;

    color:#64748B;

}

.clock{

    text-align:right;

}

.clock-time{

    font-size:15px;

    font-weight:600;

    color:#0F172A;

}

.clock-date{

    font-size:12px;

    color:#64748B;

}

@media(max-width:992px){

    .menu-toggle{

        display:flex;

        align-items:center;

        justify-content:center;

    }

    .clock{

        display:none;

    }

    .profile-role{

        display:none;

    }

}

</style>

<div class="topbar">

    <div class="topbar-left">

        <button class="menu-toggle" id="sidebarToggle">

            <i class="bi bi-list"></i>

        </button>

        <div>

            <h3 class="page-title">

                Dashboard Yayasan

            </h3>

            <div class="page-subtitle">

                Kelola campaign dan donasi dengan mudah

            </div>

        </div>

    </div>

    <div class="topbar-right">

        <div class="clock">

            <div class="clock-time" id="clockTime"></div>

            <div class="clock-date" id="clockDate"></div>

        </div>

        <div class="notification">

            <i class="bi bi-bell"></i>

            <span class="notification-badge"></span>

        </div>

        <div class="dropdown">

            <button class="profile-button"
                    data-bs-toggle="dropdown">

                <div class="avatar">

                    <?= strtoupper(substr($foundationName,0,1)); ?>

                </div>

                <div style="text-align:left">

                    <div class="profile-name">

                        <?= esc($foundationName) ?>

                    </div>

                    <div class="profile-role">

                        Yayasan

                    </div>

                </div>

                <i class="bi bi-chevron-down"></i>

            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4">

                <li>

                    <a class="dropdown-item py-2"
                       href="<?= base_url('yayasan/profile') ?>">

                        <i class="bi bi-building me-2"></i>

                        Profil Yayasan

                    </a>

                </li>

                <li>

                    <a class="dropdown-item py-2"
                       href="<?= base_url('yayasan/dashboard') ?>">

                        <i class="bi bi-speedometer2 me-2"></i>

                        Dashboard

                    </a>

                </li>

                <li><hr class="dropdown-divider"></li>

                <li>

                    <a class="dropdown-item text-danger py-2"
                       href="<?= base_url('logout') ?>">

                        <i class="bi bi-box-arrow-right me-2"></i>

                        Logout

                    </a>

                </li>

            </ul>

        </div>

    </div>

</div>

<script>

function updateClock(){

    const now=new Date();

    const jam=now.toLocaleTimeString('id-ID');

    const tanggal=now.toLocaleDateString('id-ID',{

        weekday:'long',

        day:'numeric',

        month:'long',

        year:'numeric'

    });

    document.getElementById('clockTime').innerHTML=jam;

    document.getElementById('clockDate').innerHTML=tanggal;

}

updateClock();

setInterval(updateClock,1000);

</script>