<style>
    .app-footer { padding: 0 0 28px; color: #64748b; background: #f5f8ff; }
    .footer-card {
        background: #ffffff;
        border: 1px solid var(--dk-border, #e6edf7);
        border-radius: 28px;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        box-shadow: 0 16px 42px rgba(15, 23, 42, .06);
    }
    .footer-brand { display: flex; align-items: center; gap: 12px; font-weight: 950; color: var(--dk-navy, #172339); }
    .footer-brand i {
        width: 42px; height: 42px; border-radius: 15px;
        background: linear-gradient(135deg, var(--dk-primary, #2563eb), var(--dk-secondary, #4f46e5));
        color: #ffffff; display: flex; align-items: center; justify-content: center;
        box-shadow: 0 12px 24px rgba(37, 99, 235, .22);
    }
    .footer-text { margin: 0; font-size: 14px; text-align: right; font-weight: 700; }
    .footer-links { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
    .footer-links a { color: #64748b; font-size: 14px; font-weight: 850; text-decoration: none; }
    .footer-links a:hover { color: var(--dk-primary, #2563eb); }
    @media(max-width: 768px) {
        .app-footer { padding: 0 18px 22px; }
        .footer-card { flex-direction: column; align-items: flex-start; }
        .footer-text { text-align: left; }
    }
</style>

<footer class="app-footer">
    <div class="container">
        <div class="footer-card">
            <div>
                <div class="footer-brand"><i class="fa-solid fa-hand-holding-heart"></i><span>DonasiKu</span></div>
                <p class="footer-text mt-2">© <?= date('Y') ?> Donasi Transparan. Sistem donasi aman, rapi, dan mudah dipantau.</p>
            </div>
            <div class="footer-links">
               
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
