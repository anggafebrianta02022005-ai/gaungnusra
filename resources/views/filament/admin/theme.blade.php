<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    /* =========================================
       1. VARIAN WARNA & TEMA (Theme Engine)
       ========================================= */
    :root {
        /* LIGHT MODE */
        --bg-page: #f8fafc;
        --sidebar-bg: rgba(255, 255, 255, 0.85);
        --topbar-bg: rgba(255, 255, 255, 0.7);
        --clock-bg: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
        --clock-border: #dbeafe;
        --clock-text: #1e3a8a;
        --clock-subtext: #64748b;
        --active-item-bg: linear-gradient(90deg, #eff6ff 0%, transparent 100%);
        --active-item-border: #3b82f6;
    }

    /* DARK MODE */
    .dark {
        --bg-page: #0f172a;
        --sidebar-bg: rgba(15, 23, 42, 0.85);
        --topbar-bg: rgba(15, 23, 42, 0.7);
        --clock-bg: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        --clock-border: #334155;
        --clock-text: #60a5fa;
        --clock-subtext: #94a3b8;
        --active-item-bg: linear-gradient(90deg, rgba(59, 130, 246, 0.15) 0%, transparent 100%);
        --active-item-border: #60a5fa;
    }

    /* =========================================
       2. BODY & FONT GLOBAL
       ========================================= */
    body {
        background-color: var(--bg-page) !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }

    /* =========================================
       3. SIDEBAR (Glass Effect)
       ========================================= */
    .fi-sidebar {
        background-color: var(--sidebar-bg) !important;
        backdrop-filter: blur(12px);
        border-right: 1px solid rgba(128, 128, 128, 0.1) !important;
    }

    .fi-sidebar-header {
        padding-bottom: 10px !important;
        border-bottom: 1px solid rgba(128, 128, 128, 0.05);
    }

    /* Menu Item Styling */
    .fi-sidebar-item {
        transition: all 0.2s ease;
    }

    .fi-sidebar-item-active {
        background: var(--active-item-bg) !important;
        border-left: 3px solid var(--active-item-border);
    }

    .fi-sidebar-item-active span {
        font-weight: 700 !important;
        color: var(--clock-text) !important;
    }

    /* =========================================
       4. TOPBAR (Header Mewah)
       ========================================= */
    .fi-topbar {
        background-color: var(--topbar-bg) !important;
        backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(128, 128, 128, 0.1) !important;
        position: sticky;
        top: 0;
        z-index: 40;
    }

    /* =========================================
       5. STYLE JAM DIGITAL (SIDEBAR CARD)
       ========================================= */
    #gr-sidebar-clock {
        margin: 16px;
        padding: 12px 16px;
        background: var(--clock-bg);
        border: 1px solid var(--clock-border);
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        text-align: center;
        transition: transform 0.3s ease;
    }

    #gr-sidebar-clock:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    }

    .clock-badge {
        display: inline-block;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: white;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        padding: 2px 8px;
        border-radius: 99px;
        margin-bottom: 4px;
    }

    .clock-time {
        font-family: 'Outfit', sans-serif;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--clock-text);
        line-height: 1.2;
        font-variant-numeric: tabular-nums; /* Agar angka tidak goyang */
    }

    .clock-date {
        font-size: 0.75rem;
        color: var(--clock-subtext);
        font-weight: 500;
        margin-top: 2px;
    }

    /* =========================================
       6. WIDGET & FORM (Refinement)
       ========================================= */
    .fi-wi-stats-overview-stat, .fi-section {
        border-radius: 16px !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05) !important;
    }
    
    .fi-btn-primary {
        font-family: 'Outfit', sans-serif;
        font-weight: 600;
        border-radius: 8px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        
        // --- FUNGSI UTAMA: INJECT JAM KE SIDEBAR ---
        const injectSidebarClock = () => {
            // Target: Kita cari elemen Navigasi di Sidebar
            // '.fi-sidebar nav' adalah container menu utama
            const sidebarNav = document.querySelector('.fi-sidebar nav');
            const sidebarHeader = document.querySelector('.fi-sidebar-header');

            // Cek jika elemen target ada DAN jam belum dibuat
            if ((sidebarNav || sidebarHeader) && !document.getElementById('gr-sidebar-clock')) {
                
                const clockDiv = document.createElement('div');
                clockDiv.id = 'gr-sidebar-clock';
                
                clockDiv.innerHTML = `
                    <div class="clock-badge">WITA</div>
                    <div id="gr-time-display" class="clock-time">--:--</div>
                    <div id="gr-date-display" class="clock-date">...</div>
                `;

                // Logic Penempatan:
                // Kita taruh tepat DI ATAS menu navigasi (di bawah logo)
                if (sidebarNav) {
                    sidebarNav.parentNode.insertBefore(clockDiv, sidebarNav);
                } else if (sidebarHeader) {
                    sidebarHeader.parentNode.insertBefore(clockDiv, sidebarHeader.nextSibling);
                }
            }
        };

        // --- FUNGSI UPDATE WAKTU (WITA / Asia/Makassar) ---
        const updateTime = () => {
            const timeDisplay = document.getElementById('gr-time-display');
            const dateDisplay = document.getElementById('gr-date-display');
            
            if (timeDisplay && dateDisplay) {
                const now = new Date();

                // 1. Format Jam (WITA)
                const timeString = now.toLocaleTimeString('id-ID', {
                    timeZone: 'Asia/Makassar', // KUNCI UTAMA DI SINI
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                }).replace(/\./g, ':');

                // 2. Format Tanggal
                const dateString = now.toLocaleDateString('id-ID', {
                    timeZone: 'Asia/Makassar',
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });

                timeDisplay.innerText = timeString;
                dateDisplay.innerText = dateString;
            }
        };

        // --- JALANKAN LOGIC ---
        
        // 1. Inject saat load awal
        injectSidebarClock();
        updateTime();

        // 2. Interval detik (Update waktu & Cek jika elemen hilang karena navigasi SPA)
        setInterval(() => {
            if (!document.getElementById('gr-sidebar-clock')) {
                injectSidebarClock();
            }
            updateTime();
        }, 1000);
    });
</script>