@extends('admin.admin_master')

@section('admin')
<!-- Cache bust: {{ time() }} -->
<style>
/* Hide any time/date displays */
.hide-time-display {
    display: none !important;
}

.dashboard-container {
    min-height: 100vh;
    padding: 20px 0;
    position: relative;
}

.dashboard-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    pointer-events: none;
}

.dashboard-header {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 35px;
    margin-bottom: 30px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    overflow: hidden;
}

.dashboard-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #f5576c);
    background-size: 400% 100%;
    animation: gradientShift 8s ease infinite;
}

@keyframes gradientShift {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.dashboard-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(15px);
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    position: relative;
}

.dashboard-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.dashboard-card:hover::before {
    opacity: 1;
}

.dashboard-card:hover {
    transform: translateY(-4px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.card-header-gradient {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: white;
    padding: 25px;
    border-radius: 16px 16px 0 0;
    position: relative;
    overflow: hidden;
}

.card-header-gradient::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
    transform: translateX(-100%);
    transition: transform 0.6s ease;
}

.card-header-gradient:hover::before {
    transform: translateX(100%);
}

.card-header-gradient h5 {
    margin: 0;
    font-weight: 700;
    font-size: 1.2rem;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    position: relative;
    z-index: 1;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 20px;
    margin: 25px 0;
}

.stat-item {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 22px 16px;
    border-radius: 12px;
    text-align: center;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.stat-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
    transform: translateX(-100%);
    transition: transform 0.6s ease;
}

.stat-item:hover::before {
    transform: translateX(100%);
}

.stat-item:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
}

.stat-number {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 0.85rem;
    opacity: 0.9;
    font-weight: 500;
}

.action-buttons {
    display: grid;
    gap: 8px;
    margin-top: 20px;
}

.btn-gradient {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    border: none;
    color: white;
    padding: 10px 16px;
    border-radius: 6px;
    font-weight: 500;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    text-decoration: none;
    text-align: center;
}

.btn-gradient:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(44, 62, 80, 0.3);
    color: white;
}

.btn-outline-gradient {
    background: transparent;
    border: 1px solid #2c3e50;
    color: #2c3e50;
    padding: 10px 16px;
    border-radius: 6px;
    font-weight: 500;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    text-decoration: none;
    text-align: center;
}

.btn-outline-gradient:hover {
    background: #2c3e50;
    color: white;
    transform: translateY(-1px);
}

.quick-stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    margin: 35px 0;
}

.quick-stat-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    border-radius: 16px;
    text-align: center;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.quick-stat-card::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
    transform: translateX(-100%);
    transition: transform 0.8s ease;
}

.quick-stat-card:hover::after {
    transform: translateX(100%);
}

.quick-stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.quick-stat-card:hover::before {
    opacity: 1;
}

.quick-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(44, 62, 80, 0.3);
}

.quick-stat-icon {
    font-size: 2.5rem;
    margin-bottom: 15px;
    opacity: 0.9;
}

.quick-stat-number {
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 8px;
}

.quick-stat-label {
    font-size: 1rem;
    opacity: 0.9;
    margin-bottom: 5px;
    font-weight: 500;
}

.quick-stat-subtitle {
    font-size: 0.85rem;
    opacity: 0.7;
}

.financial-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 5px;
    margin: 30px 0;
}

.financial-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    border: 1px solid #e9ecef;
}

.financial-header {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.financial-icon {
    width: 45px;
    height: 45px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    font-size: 1.3rem;
    color: white;
}

.financial-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
}

.financial-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    text-align: center;
}

.financial-item {
    padding: 15px;
    border-radius: 8px;
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    color: white;
}

.financial-amount {
    font-size: 1.6rem;
    font-weight: 700;
    margin-bottom: 5px;
}

.financial-label {
    font-size: 0.85rem;
    opacity: 0.9;
    font-weight: 500;
}

.professional-table {
    border-collapse: separate;
    border-spacing: 0 8px;
    width: 100%;
}

.professional-table thead {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    border-radius: 8px;
}

.professional-table thead th {
    padding: 16px;
    font-size: 13px;
    color: white;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: none !important;
    font-weight: 600;
}

.professional-table tbody tr {
    background: #ffffff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.professional-table tbody tr:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.professional-table td {
    padding: 16px;
    vertical-align: middle;
    font-size: 14px;
    border: none !important;
    color: #2c3e50;
}

.professional-table .badge {
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 500;
}

.toggle-desc {
    font-weight: 500;
    color: #3498db;
    text-decoration: none;
    cursor: pointer;
    transition: color 0.3s ease;
}

.toggle-desc:hover {
    color: #2980b9;
}

.task-desc {
    font-size: 13px;
    color: #7f8c8d;
    line-height: 1.5;
}

/* Responsive Design */
@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .quick-stats-row {
        grid-template-columns: 1fr;
    }
    
    .financial-overview {
        grid-template-columns: 1fr;
    }
    
    .financial-content {
        grid-template-columns: 1fr;
    }
}

/* Analytics Metrics Styling */
.analytics-metric {
    display: flex;
    align-items: center;
    padding: 20px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 12px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.analytics-metric:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    background: rgba(255, 255, 255, 0.95);
}

.metric-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    color: white;
    font-size: 1.2rem;
}

.metric-content {
    flex: 1;
}

.metric-value {
    font-size: 1.8rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 5px;
}

.metric-label {
    font-size: 0.9rem;
    color: #7f8c8d;
    font-weight: 500;
}

/* Professional Animation Classes */
.fade-in {
    animation: fadeIn 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes fadeIn {
    from { 
        opacity: 0; 
        transform: translateY(30px) scale(0.95); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0) scale(1); 
    }
}

.slide-in {
    animation: slideIn 1s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes slideIn {
    from { 
        transform: translateX(-60px); 
        opacity: 0; 
    }
    to { 
        transform: translateX(0); 
        opacity: 1; 
    }
}

/* Data Visualization Enhancements */
.chart-container {
    position: relative;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
}

.analytics-tooltip {
    background: rgba(0, 0, 0, 0.9);
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 0.85rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}

/* Spinning Animation */
.spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Enhanced Loading States */
.loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
    border-radius: 16px;
}

.loading-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

/* Data Visualization Enhancements */
.progress-ring {
    transform: rotate(-90deg);
}

.progress-ring-circle {
    transition: stroke-dashoffset 0.35s;
    transform-origin: 50% 50%;
}

/* Professional Hover Effects */
.hover-lift {
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.hover-lift:hover {
    transform: translateY(-8px);
}

/* Gradient Text Effect */
.gradient-text {
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 700;
}

/* Financial Chart Styling */
.financial-stat {
    padding: 15px 10px;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.8);
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.financial-stat:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    background: rgba(255, 255, 255, 0.95);
}

.stat-value {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 0.8rem;
    color: #6c757d;
    font-weight: 500;
}

.chart-container {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

#financialChartType {
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 4px 8px;
    font-size: 0.85rem;
    background: white;
}

#financialChartType:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    outline: none;
}
</style>

<style>
    .progress-circle {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background:
            radial-gradient(closest-side, white 79%, transparent 80% 100%),
            conic-gradient(var(--color) calc(var(--value) * 1%), #e5e5e5 0);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.9rem;
        transition: 0.4s ease-in-out;
    }
    .progress-circle:hover {
        transform: scale(1.1);
    }
</style>
<style>
    .user-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.2);
        background: rgba(255,255,255,0.25);
    }
</style>
{{-- Add some custom styles to ensure the financial overview looks neat and professional --}}
<style>
  
  .financial-card {
    border: 1px solid #e9ecef;
    border-radius: .75rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }
  .financial-header {
    padding: 1rem;
    background: #f7f8fa;
    border-bottom: 1px solid #e2e6ea;
  }
  .financial-title {
    font-weight: 600;
    font-size: 1.1rem;
    color: #2d3748;
  }
  .financial-stat {
    background: #f7f8fa;
    border-radius: .75rem;
    padding: 1rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  }
  .stat-value {
    font-size: 1.5rem;
    font-weight: 600;
  }
  .stat-label {
    color: #6c757d;
    font-size: .875rem;
    margin-top: .5rem;
  }
       .action-buttons .btn {
         min-width: 140px;
       }
       
       /* Profile Image Error Handling Styles */
       .profile-img {
           transition: opacity 0.3s ease;
       }
       
       .profile-img.error {
           opacity: 0.5;
       }
       
       .profile-placeholder {
           transition: all 0.3s ease;
           font-family: 'Arial', sans-serif;
           text-shadow: 0 1px 2px rgba(0,0,0,0.3);
       }
       
       .profile-placeholder:hover {
           transform: scale(1.05);
           box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
       }
       
       /* Fallback for broken images */
       .profile-img[src*="admin-images"]:not([src*="default.jpg"]) {
           position: relative;
       }
       
       .profile-img[src*="admin-images"]:not([src*="default.jpg"])::after {
           content: '';
           position: absolute;
           top: 0;
           left: 0;
           right: 0;
           bottom: 0;
           background: linear-gradient(135deg, #667eea, #764ba2);
           border-radius: 50%;
           display: flex;
           align-items: center;
           justify-content: center;
           color: white;
           font-size: 16px;
           font-weight: bold;
           opacity: 0;
           transition: opacity 0.3s ease;
       }
       
       .profile-img[src*="admin-images"]:not([src*="default.jpg"]).error::after {
           opacity: 1;
       }
     </style>
<style>
    :root{
        --brand-primary:#0b1b4f; /* blue-950 */
        --brand-accent:#fb923c;  /* orange-400 */
        --text-muted:#6c757d;
        --border:#e9ecef;
        --border-soft:#eef0f2;
        --card-radius:.9rem;
        --stat-number-color:#333; /* Default number color */
        --stat-number-positive:#10b981; /* Green for positive */
        --stat-number-negative:#ef4444; /* Red for negative */
    }
    .dashboard-card{
        border:1px solid var(--border);
        border-radius:var(--card-radius);
        box-shadow:0 6px 18px rgba(0,0,0,.05);
        transition:transform .15s ease, box-shadow .15s ease;
    }
    .dashboard-card:hover{ transform:translateY(-2px); box-shadow:0 10px 24px rgba(0,0,0,.08); }
    .dashboard-card .card-header{
        background:#fff; border-bottom:1px solid var(--border-soft);
        padding:.85rem 1rem;
    }
    .card-title-wrap{ display:flex; align-items:center; gap:.5rem; }
    .card-title-wrap h6{ margin:0; font-weight:700; color:var(--brand-primary); letter-spacing:.2px; }
    .subtle-date{ font-size:.75rem; color:var(--text-muted); }

    .stats-grid{ display:grid; grid-template-columns:repeat(3,1fr); gap:.75rem; }
    .stat-item{
        padding:.75rem; border:1px dashed var(--border-soft); border-radius:.75rem;
        background:#fff;
    }
    .stat-head{ display:flex; align-items:center; justify-content:center; gap:.5rem; }
    .stat-icon{
        width:28px; height:28px; border-radius:50%;
        display:flex; align-items:center; justify-content:center;
        background:rgba(11,27,79,.06);
    }
    .stat-number{ 
        font-size:1.6rem; font-weight:800; line-height:1.1; text-align:center;
        margin-top:.25rem;
        color: var(--stat-number-color); /* Default color */
        transition: color 0.3s ease;
    }

    /* Apply conditional colors for positive/negative stats */
    .stat-number.positive{ color: var(--stat-number-positive); }
    .stat-number.negative{ color: var(--stat-number-negative); }

    .stat-label{ color:var(--text-muted); font-size:.85rem; text-align:center; }
    .trend-chip{
        display:inline-flex; align-items:center; gap:.35rem;
        border-radius:999px; padding:.2rem .55rem; font-size:.75rem; font-weight:600;
    }
    .trend-up{ background:rgba(16,185,129,.12); }
    .trend-up i{ color:#10b981; }
    .trend-down{ background:rgba(239,68,68,.12); }
    .trend-down i{ color:#ef4444; }

    .action-buttons{ display:flex; flex-wrap:wrap; gap:.5rem; margin-top:1rem; }
    .btn-brand{ background:var(--brand-primary); border-color:var(--brand-primary); color:#fff; }
    .btn-brand:hover{ filter:brightness(.9); color:#fff; }
    .btn-ghost{ border:1px solid var(--border); background:#fff; }
    .btn-ghost:hover{ border-color:var(--brand-accent); color:var(--brand-primary); }

    .empty-state{
        display:flex; flex-direction:column; align-items:center; justify-content:center;
        gap:.35rem; padding:1rem; border:1px solid var(--border); border-radius:.75rem; background:#fcfcfd;
    }
    .empty-state i{ font-size:1.2rem; color:var(--text-muted); }
    .empty-state small{ color:var(--text-muted); }

    /* Mobile friendliness */
    @media (max-width: 1199.98px){ .stats-grid{ grid-template-columns:repeat(3,1fr);} }
    @media (max-width: 575.98px){ .stats-grid{ grid-template-columns:1fr 1fr; } .action-buttons .btn{ flex:1 1 auto; } }
</style>
<style>
.unique-card {
    background: linear-gradient(135deg, #ffffff, #f8faff); /* brighter solid background */
    border-radius: 10px;
    padding: 1rem;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    border: 1px solid #e2e8f0;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.unique-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 28px rgba(0,0,0,0.15);
}

.unique-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: .8rem;
    border-bottom: 1px solid #e5e7eb;
    padding-bottom: .6rem;
}

.icon-badge {
    background: linear-gradient(135deg, #4f46e5, #3b82f6);
    color: #fff;
    border-radius: 12px;
    padding: .45rem .65rem;
    font-size: 1.1rem;
    box-shadow: 0 3px 8px rgba(79,70,229,0.35);
}

.stats-grid {
    display: flex;
    justify-content: space-around;
    gap: 1rem;
    margin: 1rem 0;
}

.stat-box {
    flex: 1;
    text-align: center;
    background: #f9fafb;
    border-radius: 12px;
    padding: 1rem;
    border: 1px solid #e5e7eb;
    position: relative;
}

.stat-icon {
    font-size: 1.6rem;
    margin-bottom: .4rem;
    color: #2563eb;
}

.stat-number {
    font-size: 1.6rem;
    font-weight: 700;
    color: #111827;
}

.stat-label {
    font-size: .85rem;
    color: #6b7280;
}

.trend-chip {
    position: absolute;
    top: 6px;
    right: 8px;
    font-size: .75rem;
    padding: 3px 8px;
    border-radius: 10px;
    font-weight: 600;
    color: #fff;
}
.trend-chip.up { background: #16c784; }
.trend-chip.down { background: #ef4444; }

.action-buttons {
    display: flex;
    gap: .6rem;
    margin-top: 1rem;
    flex-wrap: wrap;
}
.action-buttons .btn-brand {
    background: linear-gradient(135deg, #4f46e5, #3b82f6);
    color: #fff;
    border: none;
    font-weight: 600;
}
.action-buttons .btn-brand:hover {
    opacity: 0.9;
}
.action-buttons .btn-outline-light {
    border: 1px solid #d1d5db;
    color: #374151;
    background: #fff;
}
 .action-buttons .btn-outline-light:hover {
     background: #f3f4f6;
 }

/* Professional Leave Management Styles */
.leave-management-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
}

.leave-management-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 50px rgba(0,0,0,0.12);
}

.leave-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid #f1f5f9;
}

.leave-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
}

.leave-status-indicator {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: #f0fdf4;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    border: 1px solid #bbf7d0;
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #22c55e;
    animation: pulse 2s infinite;
}

.status-text {
    font-size: 0.875rem;
    font-weight: 600;
    color: #16a34a;
}

.leave-date {
    background: #f8fafc;
    padding: 0.5rem 1rem;
    border-radius: 12px;
    font-size: 0.875rem;
    font-weight: 500;
    color: #64748b;
    border: 1px solid #e2e8f0;
}

.selection-panel {
    background: #f8fafc;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border: 1px solid #e2e8f0;
}

.form-group {
    margin-bottom: 0;
}

.form-label {
    color: #374151;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.form-select-lg {
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.form-select-lg:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.balance-dashboard {
    background: #ffffff;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #e2e8f0;
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f1f5f9;
}


.balance-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.balance-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 1.5rem;
    border: 2px solid #f1f5f9;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.balance-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3b82f6, #1d4ed8);
}

.balance-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border-color: #3b82f6;
}

.balance-card.credit-leave::before { background: linear-gradient(90deg, #8b5cf6, #7c3aed); }
.balance-card.casual-leave::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
.balance-card.sick-leave::before { background: linear-gradient(90deg, #ef4444, #dc2626); }
.balance-card.total-leave::before { background: linear-gradient(90deg, #10b981, #059669); }

.card-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.card-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #374151;
    font-size: 1.25rem;
    background: #f3f4f6;
    border: 2px solid #e5e7eb;
}

.credit-leave .card-icon { 
    background: #f3f4f6; 
    border-color: #8b5cf6;
    color: #8b5cf6;
}
.casual-leave .card-icon { 
    background: #f3f4f6; 
    border-color: #f59e0b;
    color: #f59e0b;
}
.sick-leave .card-icon { 
    background: #f3f4f6; 
    border-color: #ef4444;
    color: #ef4444;
}
.total-leave .card-icon { 
    background: #f3f4f6; 
    border-color: #10b981;
    color: #10b981;
}

.card-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
}

.balance-value {
    font-size: 2.5rem;
    font-weight: 800;
    color: #111827;
    line-height: 1;
    margin-bottom: 0.25rem;
}

.balance-unit {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 500;
    margin-bottom: 1rem;
}

.balance-progress {
    height: 6px;
    background: #f1f5f9;
    border-radius: 3px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #3b82f6, #1d4ed8);
    border-radius: 3px;
    transition: width 0.5s ease;
    width: 0%;
}

.analytics-panel {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
}

.analytics-header {
    background: #f8fafc;
    padding: 1.5rem;
    border-bottom: 1px solid #e2e8f0;
}

.analytics-body {
    padding: 1.5rem;
}

.chart-container {
    position: relative;
    height: 300px;
    margin-bottom: 1rem;
}

.chart-legend {
    display: flex;
    justify-content: center;
    gap: 2rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.legend-color {
    width: 12px;
    height: 12px;
    border-radius: 2px;
}

.legend-label {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 500;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

@media (max-width: 768px) {
    .balance-grid {
        grid-template-columns: 1fr;
    }
    
    .leave-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .dashboard-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
}
 
 </style>

<div class="dashboard-container">
    <div class="container-xxl">
        <!-- Analytical Dashboard Header -->
        <div class="dashboard-header fade-in">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <div class="bg-primary rounded-circle p-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-graph-up-arrow text-white fs-3"></i>
                            </div>
                        </div>
                        <div>
                            <h1 class="h2 fw-bold text-dark mb-1">Analytics Dashboard</h1>
                            <p class="text-muted mb-0">Real-time business intelligence & performance analytics</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end align-items-center">
                        <div class="me-4 text-end">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-success rounded-circle me-2" style="width: 8px; height: 8px;"></div>
                                <small class="text-success fw-semibold">System Online</small>
                            </div>
                            <div class="fw-bold text-dark fs-6">{{ now()->format('l, F d, Y') }}</div>
                            <small class="text-muted">{{ now()->format('H:i:s') }} UTC</small>
                        </div>
                        <div class="bg-gradient-primary rounded-circle p-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #667eea, #764ba2);">
                            <i class="bi bi-speedometer2 text-white fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center p-3" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1)); border-radius: 12px;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-lightning-charge text-primary me-2"></i>
                        <span class="fw-semibold text-dark">Live Analytics</span>
                    </div>
                    <div class="d-flex gap-4">
                        <div class="text-center">
                            <div class="fw-bold text-primary">{{ $totalBookings }}</div>
                            <small class="text-muted">Total Sessions</small>
                        </div>
                        <div class="text-center">
                            <div class="fw-bold text-success">{{ $activeAvailabilities }}</div>
                            <small class="text-muted">Active Schedules</small>
                        </div>
                        <div class="text-center">
                            <div class="fw-bold text-info">{{ $allUsers->count() }}</div>
                            <small class="text-muted">Total Users</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        
        <!-- Quick Analytics Bar -->
        
        <div class="row">
            <div class="col-xl-4">
                @php
                    $totalGoals = $goals->where('g_isdeleted', '!=', 1)->count();
                    $completedGoals = $goals->where('g_isdeleted', '!=', 1)->where('g_status', 'Completed')->count();
                    $pendingGoals = $goals->where('g_isdeleted', '!=', 1)->where('g_status', 'Pending')->count();
                    $notStartedGoals = $goals->where('g_isdeleted', '!=', 1)->where('g_status', 'New')->count();
                    $progressPercentage = $totalGoals > 0 ? round(($completedGoals / $totalGoals) * 100) : 0;
                @endphp 

                <div class="card p-4 card-flush bgi-no-repeat bgi-size-contain bgi-position-x-center border-0 mb-6" style="background-color: #002244;">
                    <span class="fs-2hx fw-bold text-white mb-4 me-2 lh-1 ls-n2">{{ $totalGoals }}
                    <a href="{{ route('add.gtask') }}">+ </a>
                    <div class="mt-4 d-flex justify-content gap-2">
                        <span class="text-white opacity-50 pt-1 fw-semibold fs-6">Active Projects</span>
                    </div>
                    <div class="d-flex align-items-center flex-column mt-3 w-100">
                        <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-50 w-100 mt-auto mb-2">
                            <span>{{ $totalGoals - $completedGoals }} Pending</span>
                            <span>{{ $progressPercentage }}%</span>
                        </div>
                        <div class="h-8px mx-3 w-100 bg-light-danger rounded">
                            <div class="bg-danger rounded h-8px transition-width"
                                 role="progressbar"
                                 style="width: {{ $progressPercentage }}%;"
                                 aria-valuenow="{{ $progressPercentage }}"
                                 aria-valuemin="0"
                                 aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-5">
                    <div class="card-body pt-4 pb-4">
                        <div class="text-center mb-5">
                          <h6 class="text-gray-800 fs-5" style="font-weight: 700;">Project Status</h6>
                        </div>

                        <div class="d-flex align-items-center justify-content-center gap-5 text-start">
                            <div>
                                    <canvas id="goalStatusChart" width="140" height="140"></canvas>
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <div class="d-flex fw-semibold align-items-center mb-2">
                                    <div class="bullet me-3 w-10px h-10px rounded-circle" style="background-color: #002D62;"></div>
                                    <div class="text-gray-700 fs-6">{{ $completedGoals }} Completed</div>
                                </div>
                                <div class="d-flex fw-semibold align-items-center mb-2">
                                    <div class="bullet me-3 w-10px h-10px rounded-circle" style="background-color: #0066b2;"></div>
                                    <div class="text-gray-700 fs-6">{{ $pendingGoals }} Pending</div>
                                </div>
                                <div class="d-flex fw-semibold align-items-center">
                                    <div class="bullet me-3 w-10px h-10px rounded-circle" style="background-color: #4B9CD3;"></div>
                                    <div class="text-gray-700 fs-6">{{ $notStartedGoals }} New</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-5">
                @php
                    $userGoals = (Auth::user()->role === 'Admin')
                        ? $goals->where('g_isdeleted', '!=', 1)
                        : $goals->where('g_assigned', Auth::id())->where('g_isdeleted', '!=', 1);

                    $pendingCount = $userGoals->where('g_status', 'Pending')->count();
                    $newCount = $userGoals->where('g_status', 'New')->count();
                    $totalPendingNew = $pendingCount + $newCount;
                    $total = $goals->count();

                    $todayAssignedCount = $userGoals->where('created_at', '>=', \Carbon\Carbon::today())->count();
                    $todayPendingNewCount = $userGoals->filter(function ($goal) {
                        return in_array($goal->g_status, ['Pending', 'New']) && \Carbon\Carbon::parse($goal->created_at)->isToday();
                    })->count();

                    //this month task
                    $startOfMonth = Carbon\Carbon::now()->startOfMonth();
                    $endOfMonth = Carbon\Carbon::now()->endOfMonth();

                    $thismonth = $userGoals->filter(function ($goal) use ($startOfMonth, $endOfMonth) {
                        return Carbon\Carbon::parse($goal->created_at)->between($startOfMonth, $endOfMonth);
                    })->count();
                    //this month pending task
                    $thisMonthPendingNew = $userGoals->filter(function ($goal) use ($startOfMonth, $endOfMonth) {
                        return \Carbon\Carbon::parse($goal->created_at)->between($startOfMonth, $endOfMonth)
                            && in_array($goal->g_status, ['Pending', 'New']);
                    })->count();

                    // This week task
                    $startOfWeek = Carbon\Carbon::now()->startOfWeek();
                    $endOfWeek = Carbon\Carbon::now()->endOfWeek();

                    $thisweek = $userGoals->filter(function ($goal) use ($startOfWeek, $endOfWeek) {
                        return Carbon\Carbon::parse($goal->created_at)->between($startOfWeek, $endOfWeek);
                    })->count();

                    $thisWeekPendingNew = $userGoals->filter(function ($goal) use ($startOfWeek, $endOfWeek) {
                        return \Carbon\Carbon::parse($goal->created_at)->between($startOfWeek, $endOfWeek)
                            && in_array($goal->g_status, ['Pending', 'New']);
                    })->count();

                    $totalMinutes = 0;
                @endphp

                <div class="card border-0 shadow-sm mb-6" style="background: linear-gradient(to left,  #0072ff, #25396f);">
                    <div class="card-body text-white p-9">
                        <h1 class="fw-bold mb-1 text-white">My Tasks</h1><br>
                        <p>You have tasks to complete</p>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
                    <div class="col">
                        <div class="bg-white shadow-sm rounded-4 text-center px-4 py-5 h-100">
                            <div class="fs-1 fw-bold text-primary mb-2">{{ $todayAssignedCount }}</div>
                            <div class="fs-7 text-muted">Today's Task</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="bg-white shadow-sm rounded-4 text-center px-4 py-5 h-100">
                            <div class="fs-1 fw-bold text-primary mb-2">{{$thisweek}}</div>
                            <div class="fs-7 text-muted">This Week</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="bg-white shadow-sm rounded-4 text-center px-4 py-5 h-100">
                            <div class="fs-1 fw-bold text-primary mb-2">{{$thismonth}}</div>
                            <div class="fs-7 text-muted">This Month</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="bg-white shadow-sm rounded-4 text-center px-4 py-5 h-100">
                            <div class="fs-1 fw-bold text-primary mb-2">{{ $todayPendingNewCount }}</div>
                            <div class="fs-7 text-muted">Today's Pending</div>
                        </div>
                    </div>
                  
                    <div class="col">
                        <div class="bg-white shadow-sm rounded-4 text-center px-4 py-5 h-100">
                            <div class="fs-1 fw-bold text-primary mb-2">{{$thisWeekPendingNew}} </div>
                            <div class="fs-7 text-muted">This Week Pending</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="bg-white shadow-sm rounded-4 text-center px-4 py-5 h-100">
                            <div class="fs-1 fw-bold text-primary mb-2">{{$thisMonthPendingNew}} </div>
                            <div class="fs-7 text-muted">This Month Pending</div>
                        </div>
                    </div>
                </div>    
            </div>
            <div class="col-xl-3">
                <div class="card" >
                        <a href="http://127.0.0.1:8000/leave/create" target="_blank">
                            <img src="{{ asset('backend/assets/media/logos/l2.jpg') }}" class="rounded-2" alt="Leave Image" style="width: 100%; height: 356px"/>
                        </a>
                </div>
            </div>
        </div>
        @php
            use Carbon\Carbon;
            $user = auth()->user();
        @endphp

        @if ($user && in_array($user->role, ['Admin', 'Customer Support']))
            <div class="text-center mb-5">
                <h2 class="fw-bold">📈 Support Insights</h2>
                <p class="text-muted">Visual summary of your support categorized by time and status</p>
            </div>

            <div class="row mb-6 ">
                @php
                    $supports = $support->where('s_isdeleted', '!=', 1);

                    $today = Carbon::today();
                    $startOfWeek = Carbon::now()->startOfWeek();
                    $endOfWeek = Carbon::now()->endOfWeek();
                    $startOfMonth = Carbon::now()->startOfMonth();
                    $endOfMonth = Carbon::now()->endOfMonth();

                    $statuses = ['Hot', 'Warm', 'Cold', 'Dead'];
                    $statusCountsToday = [];
                    $statusCountsWeek = [];
                    $statusCountsMonth = [];
                    $totalCountsToday = $totalCountsWeek = $totalCountsMonth = 0;

                    foreach ($statuses as $status) {
                        $statusCountsToday[$status] = $supports->filter(fn($s) => $s->Status === $status && Carbon::parse($s->created_at)->isToday())->count();
                        $statusCountsWeek[$status] = $supports->filter(fn($s) => $s->Status === $status && Carbon::parse($s->created_at)->between($startOfWeek, $endOfWeek))->count();
                        $statusCountsMonth[$status] = $supports->filter(fn($s) => $s->Status === $status && Carbon::parse($s->created_at)->between($startOfMonth, $endOfMonth))->count();

                        $totalCountsToday += $statusCountsToday[$status];
                        $totalCountsWeek += $statusCountsWeek[$status];
                        $totalCountsMonth += $statusCountsMonth[$status];
                    }
                @endphp

                @foreach([
                        ['label' => 'Today', 'counts' => $statusCountsToday, 'total' => $totalCountsToday, 'bg' => '#f8f9fa'],
                        ['label' => 'This Week', 'counts' => $statusCountsWeek, 'total' => $totalCountsWeek, 'bg' => '#f8f9fa'],
                        ['label' => 'This Month', 'counts' => $statusCountsMonth, 'total' => $totalCountsMonth, 'bg' => '#f8f9fa'],
                    ] as $panel)
                    <div class="col-xl-4">
                        <div class="card shadow-sm border-0" style="background-color: {{ $panel['bg'] }};">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-5">
                                    <h5 class="fw-semibold m-0">{{ $panel['label'] }}</h5>
                                    <span class="badge bg-dark fs-6">{{ $panel['total'] }} Total</span>
                                </div>

                                <div class="d-flex justify-content-around flex-wrap">
                                    @foreach(['Hot', 'Warm', 'Cold', 'Dead'] as $status)
                                        @php
                                            $count = $panel['counts'][$status];
                                            $percentage = $panel['total'] ? round(($count / $panel['total']) * 100) : 0;
                                            $color = match($status) {
                                                'Hot' => '#e74c3c',
                                                'Warm' => '#f39c12',
                                                'Cold' => '#3498db',
                                                'Dead' => '#7f8c8d'
                                            };
                                        @endphp
                                        <div class="text-center m-1">
                                            <div class="progress-circle" style="--value: {{ $percentage }}; --color: {{ $color }}">
                                                <span>{{ $percentage }}%</span>
                                            </div>
                                            <small class="d-block mt-2">{{ $status }} ({{ $count }})</small>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <div class="row">
            <div class="col-xl-3">
                <div class="card border-0 shadow-lg rounded-2 p-4 w-100 mb-6" style="max-width: 700px; margin: 0 auto; background: linear-gradient(135deg, #00c6ff, #0072ff,#002244); color: white;">
                    <div class="row g-3 justify-content-center">
                        <div class="card  border-0 bg-transparent">
                            <div class="card-body d-flex flex-column align-items-center text-center">
                                <div class="mb-1">
                                    <h3 class="fw-bold text-white mb-2">Have you tried</h3>
                                    <h6 class="fw-bolder" style="color: #002244;">Our New Smart Invoice Manager?</h6>
                                    <p class="mt-3 mb-0 " style=" color: #e0f7fa;">
                                        Simplify your invoicing workflow with <strong>automation</strong>, <strong>real-time tracking</strong>, and <strong>zero hassle</strong>. 
                                        Designed by <span style="color: #002244;"><a href="https://www.repunext.com/">RepuNEXT</a></span> to make your business smarter and faster!
                                    </p>
                                </div>

                                <div class="py-5">
                                    <img src="{{ asset('backend/assets/media/logos/2.svg') }}"
                                        style="max-width: 180px;" alt="Invoice Manager Illustration">
                                </div>

                                <div class="pt-3">
                                    <a href="http://127.0.0.1:8000/salesorder/add"
                                    class="btn px-4 py-2 me-2 fw-semibold"
                                    style="background-color: #002244; border: none; color: white;">
                                        🚀 Try Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9">
                <div class="card mb-2" style="height: 488px; overflow: hidden;">
                    <div class="card-header position-relative py-4 border-0 bg-light rounded-top shadow-sm">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                            <h3 class="card-title text-dark fw-bold fs-3 mb-0 ps-4">Active Tasks</h3>
                            <form id="dashboardFilterForm" class="d-flex align-items-center gap-10 bg-white border rounded px-3 py-2 shadow-sm justify-content-end" style="border-radius: 12px;">
                                <select name="user_id" id="userSelect" class="form-select-2 form-select-sm border-0" style="min-width: 140px;">
                                    <option value="">All Users</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ ($userId == $user->id) ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <input type="text" name="date_range" id="datePicker" value="{{ $dateRange }}" class="form-control form-control-sm border-0" placeholder="Date or Range" style="min-width: 160px;" />
                                <input type="hidden" id="currentFilter" name="filter" value="{{ $filter }}">
                                <button type="submit" class="btn btn-sm btn-dark rounded px-3">Filter</button>
                            </form>

                            <a href="{{ route('add.ttimecat') }}"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user" >
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                    </svg>
                                </span>Add</button>
                            </a>

                            <button id="refreshButton" class="btn btn-primary ms-2">↻</button>
                        </div>
                        <ul class="nav nav-pills gap-2 justify-content-center mt-5" role="tablist">
                            @php
                                $filters = ['daily' => 'Daily', 'weekly' => 'Weekly', 'monthly' => 'Monthly'];
                            @endphp
                            @foreach($filters as $key => $label)
                                <li class="nav-item" role="presentation">
                                    <a href="javascript:void(0);" 
                                        class="nav-link px-3 py-2 rounded {{ ($filter === $key && !$dateRange) ? 'active bg-dark text-white' : 'bg-white border text-dark' }}"
                                        data-filter="{{ $key }}">
                                        {{ $label }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Scrollable Content Section -->
                    <div id="dashboard-content" style="height: calc(100% - 135px); overflow-y: auto; padding: 10px;">
                        @include('admin.dashboard_partial')
                    </div>
                </div>
            </div>
        </div>
       
         <!-- Leave Management Section -->
         <div class="row gx-2 mt-1">
             <div class="col-12">
                 <div class="leave-management-card">
                     <div class="leave-header">
                         <div class="d-flex align-items-center gap-3">
                             <div class="leave-icon">
                                 <i class="bi bi-calendar-check-fill"></i>
                             </div>
                             <div>
                                 <h5 class="mb-0 fw-bold text-dark">Leave Management System</h5>
                                 <p class="mb-0 text-muted small">Track and manage employee leave balances</p>
                             </div>
                         </div>
                         
                     </div>
                     
                     <div class="leave-body">
                         <!-- Professional Selection Panel -->
                         <div class="selection-panel">
                             <div class="row g-3">
                                 <div class="col-lg-6">
                                     <div class="form-group">
                                         <label class="form-label fw-semibold text-dark">
                                             <i class="bi bi-person-fill me-2"></i>Select Employee
                                         </label>
                                        <select class="form-select form-select-lg" id="leaveUserSelect">
                                            <option value="">Choose an employee...</option>
                                            @foreach($allUsers as $user)
                                                <option value="{{ $user->id }}" {{ auth()->id() == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->username }})</option>
                                            @endforeach
                                        </select>
                                     </div>
                                 </div>
                                 <div class="col-lg-6">
                                     <div class="form-group">
                                         <label class="form-label fw-semibold text-dark">
                                             <i class="bi bi-calendar3 me-2"></i>Select Year
                                         </label>
                                         <select class="form-select form-select-lg" id="leaveYearSelect">
                                             @for($year = date('Y'); $year >= 2020; $year--)
                                                 <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                                             @endfor
                                         </select>
                                     </div>
                                 </div>
                             </div>
                         </div>

                        <!-- Professional Leave Balance Dashboard -->
                        <div id="leaveBalanceCards" style="display: none;">
                            <div class="balance-dashboard">
                               
                                
                                <div class="balance-grid">
                                    <div class="balance-card credit-leave">
                                        <div class="card-header">
                                            <div class="card-icon">
                                                <i class="bi bi-credit-card-2-front-fill"></i>
                                            </div>
                                            <div class="card-title">Credit Leave</div>
                                        </div>
                                        <div class="card-body">
                                            <div class="balance-value" id="creditLeaveBalance">0</div>
                                            <div class="balance-unit">Days</div>
                                            <div class="balance-progress">
                                                <div class="progress-bar" id="creditProgress"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="balance-card casual-leave">
                                        <div class="card-header">
                                            <div class="card-icon">
                                                <i class="bi bi-calendar-check-fill"></i>
                                            </div>
                                            <div class="card-title">Casual Leave</div>
                                        </div>
                                        <div class="card-body">
                                            <div class="balance-value" id="casualLeaveBalance">0</div>
                                            <div class="balance-unit">Days</div>
                                            <div class="balance-progress">
                                                <div class="progress-bar" id="casualProgress"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="balance-card sick-leave">
                                        <div class="card-header">
                                            <div class="card-icon">
                                                <i class="bi bi-heart-pulse-fill"></i>
                                            </div>
                                            <div class="card-title">Sick Leave</div>
                                        </div>
                                        <div class="card-body">
                                            <div class="balance-value" id="sickLeaveBalance">0</div>
                                            <div class="balance-unit">Days</div>
                                            <div class="balance-progress">
                                                <div class="progress-bar" id="sickProgress"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="balance-card total-leave">
                                        <div class="card-header">
                                            <div class="card-icon">
                                                <i class="bi bi-graph-up-arrow"></i>
                                            </div>
                                            <div class="card-title">Total Balance</div>
                                        </div>
                                        <div class="card-body">
                                            <div class="balance-value" id="totalLeaveBalance">0</div>
                                            <div class="balance-unit">Days</div>
                                            <div class="balance-progress">
                                                <div class="progress-bar" id="totalProgress"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Professional Analytics Chart -->
                        <div id="monthlyLeaveChart" style="display: none;">
                            <div class="analytics-panel">
                                <div class="analytics-header">
                                    <div>
                                        <h6 class="mb-1 fw-bold text-dark">
                                            <i class="bi bi-bar-chart-line-fill me-2"></i>Monthly Leave Analytics
                                        </h6>
                                        <p class="mb-0 text-muted small">Leave usage pattern for <span id="selectedUserName" class="fw-semibold text-primary"></span></p>
                                    </div>
                                </div>
                                <div class="analytics-body">
                                    <div class="chart-container">
                                        <canvas id="monthlyLeaveChartCanvas" height="120"></canvas>
                                    </div>
                                    <div class="chart-legend">
                                        <div class="legend-item">
                                            <span class="legend-color" style="background: #3b82f6;"></span>
                                            <span class="legend-label">Leave Taken (Days)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Person Availability -->
        <div class="row gx-4 mt-3">
            <div class="col-xl-6">
                <div class="unique-card h-100">
                    <div class="unique-header">
                        <div class="d-flex align-items-center gap-2">
                            <span class="icon-badge"><i class="bi bi-people-fill"></i></span>
                            <h6 class="mb-0 fw-bold">Person Availability</h6>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span class="small subtle-date">{{ now()->format('M j, Y') }}</span>
                            <a href="{{ route('availability.index') }}" class="header-link" data-bs-toggle="tooltip" title="Open availability list">
                                <i class="bi bi-arrow-right-circle-fill"></i>
                            </a>
                        </div>
                    </div>

                    <div class="unique-body">
                        @php
                            $activeAvailabilities = $activeAvailabilities ?? 0;
                            $todayAvailableUsers = $todayAvailableUsers ?? 0;
                            $thisWeekAvailableUsers = $thisWeekAvailableUsers ?? 0;
                            $availabilityTrend = $availabilityTrend ?? null;
                        @endphp

                        @if(($activeAvailabilities + $todayAvailableUsers + $thisWeekAvailableUsers) === 0)
                            <div class="empty-state text-center py-4">
                                <i class="bi bi-emoji-neutral fs-3 text-muted"></i>
                                <p class="small mb-2">No availability scheduled yet.</p>
                                <a class="btn btn-sm btn-brand" href="{{ route('availability.create') }}">
                                    <i class="bi bi-plus-circle me-1"></i>Add Availability
                                </a>
                            </div>
                        @else
                            <div class="stats-grid">
                                <div class="stat-box">
                                    <span class="stat-icon"><i class="bi bi-clock-history"></i></span>
                                    @if($availabilityTrend && $availabilityTrend['dir']==='up')
                                        <span class="trend-chip up"><i class="bi bi-arrow-up-right"></i>{{ $availabilityTrend['val'] }}%</span>
                                    @elseif($availabilityTrend && $availabilityTrend['dir']==='down')
                                        <span class="trend-chip down"><i class="bi bi-arrow-down-right"></i>{{ $availabilityTrend['val'] }}%</span>
                                    @endif
                                    <h4 class="stat-number">{{ $activeAvailabilities }}</h4>
                                    <p class="stat-label">Active Schedules</p>
                                </div>

                                <div class="stat-box">
                                    <span class="stat-icon"><i class="bi bi-calendar-check"></i></span>
                                    <h4 class="stat-number">{{ $todayAvailableUsers }}</h4>
                                    <p class="stat-label">Today Available</p>
                                </div>

                                <div class="stat-box">
                                    <span class="stat-icon"><i class="bi bi-calendar-week"></i></span>
                                    <h4 class="stat-number">{{ $thisWeekAvailableUsers }}</h4>
                                    <p class="stat-label">This Week</p>
                                </div>
                            </div>
                        @endif

                        <div class="action-buttons d-flex justify-content-center gap-2 mt-3 ">
                            <a href="{{ route('availability.create') }}" class="btn btn-brand btn-sm"><i class="bi bi-plus-circle me-1"></i>Add</a>
                            <a href="{{ route('availability.check-form') }}" class="btn btn-outline-light btn-sm"><i class="bi bi-search me-1"></i>Quick Check</a>
                        </div>
                    </div>
                </div>
            </div>
    

            <!-- Studio Booking -->
            <div class="col-xl-6 ">
                <div class="unique-card h-100">
                    <div class="unique-header">
                        <div class="d-flex align-items-center gap-2">
                            <span class="icon-badge"><i class="bi bi-camera-video-fill"></i></span>
                            <h6 class="mb-0 fw-bold">Studio Booking</h6>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span class="small subtle-date">{{ now()->format('M j, Y') }}</span>
                            <a href="{{ route('booking.index') }}" class="header-link" data-bs-toggle="tooltip" title="Open bookings">
                                <i class="bi bi-arrow-right-circle-fill"></i>
                            </a>
                        </div>
                    </div>

                    <div class="unique-body">
                        @php
                            $todayBookings = $todayBookings ?? 0;
                            $thisWeekBookings = $thisWeekBookings ?? 0;
                            $totalBookings = $totalBookings ?? 0;
                            $bookingTrend = $bookingTrend ?? null;
                        @endphp

                        @if(($todayBookings + $thisWeekBookings + $totalBookings) === 0)
                            <div class="empty-state text-center py-4">
                                <i class="bi bi-calendar2-x fs-3 text-muted"></i>
                                <p class="small mb-2">No bookings yet. Get started below.</p>
                                <a class="btn btn-sm btn-brand" href="{{ route('booking.index') }}">
                                    <i class="bi bi-plus-circle me-1"></i>New Booking
                                </a>
                            </div>
                        @else
                            <div class="stats-grid">
                                <div class="stat-box">
                                    <span class="stat-icon"><i class="bi bi-brightness-alt-high"></i></span>
                                    @if($bookingTrend && $bookingTrend['dir']==='up')
                                        <span class="trend-chip up"><i class="bi bi-arrow-up-right"></i>{{ $bookingTrend['val'] }}%</span>
                                    @elseif($bookingTrend && $bookingTrend['dir']==='down')
                                        <span class="trend-chip down"><i class="bi bi-arrow-down-right"></i>{{ $bookingTrend['val'] }}%</span>
                                    @endif
                                    <h4 class="stat-number">{{ $todayBookings }}</h4>
                                    <p class="stat-label">Today’s Slots</p>
                                </div>

                                <div class="stat-box">
                                    <span class="stat-icon"><i class="bi bi-calendar-week"></i></span>
                                    <h4 class="stat-number">{{ $thisWeekBookings }}</h4>
                                    <p class="stat-label">This Week</p>
                                </div>

                                <div class="stat-box">
                                    <span class="stat-icon"><i class="bi bi-collection"></i></span>
                                    <h4 class="stat-number">{{ $totalBookings }}</h4>
                                    <p class="stat-label">Total</p>
                                </div>
                            </div>
                        @endif

                        <div class="action-buttons">
                            <a href="{{ route('booking.index') }}" class="btn btn-brand btn-sm"><i class="bi bi-list-ul me-1"></i>Bookings</a>
                            <a href="{{ route('booking.index') }}" class="btn btn-outline-light btn-sm"><i class="bi bi-plus-circle me-1"></i>New</a>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

                <!-- Financial Analytics Dashboard -->
        <div class="financial-overview ">
            <div class="financial-card">
                <div class="financial-header d-flex align-items-center justify-content-between">
                    <div class="financial-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <div class="financial-title">Financial Analytics</div>
                    <div class="ms-auto">
                        <select id="financialChartType" class="form-select form-select-sm" style="width: auto;">
                            <option value="bar">Bar Chart</option>
                            <option value="line">Line Chart</option>
                            <option value="doughnut">Doughnut Chart</option>
                        </select>
                    </div>
                </div>
                <div class="financial-content">
                    <div class="chart-container" style="height: 300px; position: relative;">
                        <canvas id="financialChart"></canvas>
                    </div>
                    
                    <div class="row mt-2    ">
                        <!-- Total Revenue -->
                        <div class="col-md-6 text-center">
                            <div class="financial-stat">
                                <div class="stat-value text-success">${{ number_format($Final, 0) }}</div>
                                <div class="stat-label">Total Revenue</div>
                            </div>
                        </div>
                        <!-- Total Expenses -->
                        <div class="col-md-6 text-center">
                            <div class="financial-stat">
                                <div class="stat-value text-danger">${{ number_format($totalExpense, 0) }}</div>
                                <div class="stat-label">Total Expenses</div>
                            </div>
                        </div>
                        <!-- Monthly Revenue -->
                        <div class="col-md-6 text-center">
                            <div class="financial-stat">
                                <div class="stat-value text-primary">${{ number_format($MonthlyFinal, 0) }}</div>
                                <div class="stat-label">Monthly Revenue</div>
                            </div>
                        </div>
                        <!-- Monthly Expense -->
                        <div class="col-md-6 text-center">
                            <div class="financial-stat">
                                <div class="stat-value text-warning">${{ number_format($monthlyExpense, 0) }}</div>
                                <div class="stat-label">Monthly Expense</div>
                            </div>
                        </div>
                        <div class="action-buttons d-flex justify-content-center mt-4 mb-6 gap-3">
                            <a href="{{ route('revenue-expense.index') }}" class="btn btn-brand btn-sm">
                                <i class="bi bi-list-ul me-1"></i>View Records
                            </a>
                            <a href="{{ route('revenue.create') }}" class="btn btn-ghost btn-sm">
                                <i class="bi bi-plus-circle me-1"></i>Add Entry
                            </a>
                            <a href="{{ route('revenue-expense.index') }}" class="btn btn-ghost btn-sm">
                                <i class="bi bi-bar-chart me-1"></i>Reports
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
        
    </div>
</div>
            
      
       
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Timesheet -->
<script>
    //timesheet
    $(document).ready(function () {
        flatpickr("#datePicker", {
            mode: "range",
            dateFormat: "Y-m-d"
        });

        $('#dashboardFilterForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('dashboard.data') }}",
                method: 'GET',
                data: $(this).serialize(),
                success: function (response) {
                    $('#dashboard-content').html(response.html);

                    // ✅ Render the bar chart after AJAX
                    if (document.getElementById('categoryChart')) {
                        const ctx = document.getElementById('categoryChart').getContext('2d');
                        const labels = JSON.parse(document.getElementById('categoryChart').getAttribute('data-labels'));
                        const values = JSON.parse(document.getElementById('categoryChart').getAttribute('data-values'));
                        const total = values.reduce((a, b) => a + b, 0);
                        const percentData = values.map(v => ((v / total) * 100).toFixed(2));

                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Time Spent (%)',
                                    data: percentData,
                                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1,
                                    borderRadius: 8
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    tooltip: {
                                        callbacks: {
                                            label: context => context.parsed.y + '%'
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        max: 100,
                                        ticks: {
                                            callback: value => value + '%'
                                        }
                                    }
                                }
                            }
                        });
                    }
                },
                error: function (xhr) {
                    console.error("Error:", xhr.responseJSON || xhr.statusText);
                    // Show user-friendly error message
                    $('#dashboard-content').html('<div class="alert alert-danger">Failed to load data. Please try again.</div>');
                }
            });
        });

        $('.nav-link').on('click', function (e) {
            e.preventDefault();
            $('.nav-link').removeClass('active bg-dark text-white').addClass('bg-white border text-dark');
            $(this).removeClass('bg-white border text-dark').addClass('active bg-dark text-white');
            $('#currentFilter').val($(this).data('filter'));
            $('#dashboardFilterForm').submit();
        });

        $('#refreshButton').on('click', function () {
            $('#userSelect').val('');
            $('#datePicker').val('');
            $('#currentFilter').val('daily');
            $('.nav-link').removeClass('active bg-dark text-white').addClass('bg-white border text-dark');
            $('.nav-link[data-filter="daily"]').addClass('active bg-dark text-white').removeClass('bg-white border text-dark');
            $('#dashboardFilterForm').submit();
        });

        $(document).on('click', '.toggle-desc', function () {
            const id = $(this).data('id');
            $('#desc-' + id).toggle();
        });

        $(document).on('click', '.toggle-date', function () {
            const dateSlug = $(this).data('date');
            const row = $('#tasks-' + dateSlug);
            const isVisible = row.is(':visible');
            if (!isVisible) {
                row.slideDown(200);
                $(this).text('Hide Tasks');
            } else {
                row.slideUp(200);
                $(this).text('View Tasks');
            }
        });
    });
    
    
</script>



 <script>
    document.addEventListener("DOMContentLoaded", function () {
        const chartElement = document.getElementById('goalStatusChart');
        if (!chartElement) {
            console.warn('Goal status chart element not found');
            return;
        }
        const ctx = chartElement.getContext('2d');

        const gradient1 = ctx.createLinearGradient(0, 0, 0, 250);
        gradient1.addColorStop(0, '#002D62');
        gradient1.addColorStop(1, '#0072ff');

        const gradient2 = ctx.createLinearGradient(0, 0, 0, 250);
        gradient2.addColorStop(0, '#0066b2');
        gradient2.addColorStop(1, '#4facfe');

        const gradient3 = ctx.createLinearGradient(0, 0, 0, 250);
        gradient3.addColorStop(0, '#4B9CD3');
        gradient3.addColorStop(1, '#25396f');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Pending', 'New'],
                datasets: [{
                    data: [{{ $completedGoals }}, {{ $pendingGoals }}, {{ $notStartedGoals }}],
                    backgroundColor: [gradient1, gradient2, gradient3],
                    borderColor: '#fff',
                    borderWidth: 3,
                    hoverOffset: 12,
                    borderRadius: 10
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#ffffff',
                        titleColor: '#000',
                        bodyColor: '#000',
                        borderColor: '#ddd',
                        borderWidth: 1,
                        titleFont: { weight: 'bold' },
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                return `${label}: ${value}`;
                            }
                        }
                    }
                }
            },
            plugins: [{
                id: 'centerText',
                afterDraw: function(chart) {
                    const tooltip = chart.tooltip;
                    if (!tooltip || !tooltip.opacity) {
                        const { width, height } = chart;
                        const ctx = chart.ctx;
                        ctx.restore();
                        ctx.font = "bold 16px Arial";
                        ctx.textAlign = "center";
                        ctx.textBaseline = "middle";
                        ctx.fillStyle = "#25396f";
                        ctx.fillText("Goals", width / 2, height / 2);
                        ctx.save();
                    }
                }
            }]
        });
    });
</script>



<!-- Leave Summary -->
<script>
    function fetchLeaveBalance() {
        const startDate = $('#start_date').val();
        const endDate = $('#end_date').val();

        if (!startDate || !endDate) {
            $('#leave-balance-table').html('<tr><td colspan="3" class="text-center text-warning">Please select both start and end dates</td></tr>');
            return;
        }

        $('#balanceLeaveTableWrapper').show(); // ✅ Show the table
        $('#leave-balance-table').html('<tr><td colspan="3" class="text-center text-primary">Loading data...</td></tr>');

        $.ajax({
            url: "{{ url('/fetch-leave-balance') }}",
            type: "GET",
            data: { start_date: startDate, end_date: endDate },
            dataType: "json",
            success: function(response) {
                let rows = '';

                if (response.status === 'success' && response.data.length > 0) {
                    $.each(response.data, function(index, leave) {
                        const fmt = (v) => {
                            const n = parseFloat(v || 0);
                            return Number.isInteger(n) ? n : n.toFixed(1);
                        };

                        rows += `
                            <tr class="text-center">
                                <td>${index + 1}</td>
                                <td>${leave.user_name}</td>
                                <td>${fmt(leave.credit_days)}</td>
                                <td>${fmt(leave.casual_days)}</td>
                                <td>${fmt(leave.sick_days)}</td>
                                <td class="fw-bold">${fmt(leave.total_days)}</td>
                            </tr>
                        `;
                    });
                } else {
                    rows = '<tr><td colspan="6" class="text-center text-danger">No data available for the selected date range</td></tr>';
                }

                $('#leave-balance-table').html(rows);
            },
            error: function(xhr) {
                console.error('Leave balance fetch error:', xhr.responseJSON || xhr.statusText);
                $('#leave-balance-table').html('<tr><td colspan="3" class="text-center text-danger">Error fetching data. Please try again.</td></tr>');
            }
        });
    }

    function resetFilter() {
        $('#start_date').val('2025-01-01');
        $('#end_date').val('{{ \Carbon\Carbon::now()->format("Y-m-d") }}');

        // ✅ Hide the whole balance leave table (including thead)
        $('#balanceLeaveTableWrapper').hide();

        // Optionally clear the rows (not required if hiding the whole wrapper)
        $('#leave-balance-table').html('<tr><td colspan="3" class="text-center text-muted">Please select a date range to view data.</td></tr>');
    }

    // Leave Management Functions
    function loadLeaveData() {
        const userId = $('#leaveUserSelect').val();
        const year = $('#leaveYearSelect').val();
        
        if (!userId || userId === '' || userId === '0') {
            $('#leaveBalanceCards').hide();
            $('#monthlyLeaveChart').hide();
            return;
        }
        
        // Show the cards and chart
        $('#leaveBalanceCards').show();
        $('#monthlyLeaveChart').show();
        
        // Update selected user name
        const selectedUserName = $('#leaveUserSelect option:selected').text();
        $('#selectedUserName').text(selectedUserName);

        $.ajax({
            url: "{{ url('/fetch-user-monthly-leave') }}",
            type: "GET",
            data: { user_id: userId, year: year },
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    // Update balance cards
                    $('#creditLeaveBalance').text(response.user_balance.credit_leave_days);
                    $('#casualLeaveBalance').text(response.user_balance.casual_leave_days);
                    $('#sickLeaveBalance').text(response.user_balance.sick_leave_days);
                    $('#totalLeaveBalance').text(response.user_balance.total_balance_days);

                    // Create monthly chart
                    createLeaveChart(response.monthly_data);
                } else {
                    alert('Error: ' + (response.message || 'Unknown error occurred'));
                }
            },
            error: function(xhr) {
                alert('Error fetching data: ' + (xhr.responseJSON?.message || xhr.statusText || 'Unknown error'));
            }
        });
    }

    // Function to create monthly leave chart
    function createLeaveChart(monthlyData) {
        const ctx = document.getElementById('monthlyLeaveChartCanvas').getContext('2d');
        
        // Destroy existing chart if it exists
        if (window.leaveChart) {
            window.leaveChart.destroy();
        }

        // Prepare data for chart
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const leaveData = new Array(12).fill(0);
        
        monthlyData.forEach(item => {
            leaveData[item.month - 1] = parseFloat(item.total_taken_leave);
        });

        window.leaveChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Leave Taken (Days)',
                    data: leaveData,
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        bottom: 40
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed.y;
                                return value + ' day' + (value !== 1 ? 's' : '');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                return value + ' day' + (value !== 1 ? 's' : '');
                            }
                        }
                    },
                    x: {
                        ticks: {
                            maxRotation: 0,
                            padding: 10
                        }
                    }
                },
                animation: {
                    onComplete: function() {
                        // Add custom labels below month names with proper spacing
                        const chart = this;
                        const ctx = chart.ctx;
                        ctx.font = 'bold 10px Arial';
                        ctx.fillStyle = '#6b7280';
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'top';
                        
                        chart.data.datasets.forEach((dataset, datasetIndex) => {
                            const meta = chart.getDatasetMeta(datasetIndex);
                            meta.data.forEach((element, index) => {
                                const value = dataset.data[index];
                                if (value > 0) {
                                    const x = element.x;
                                    const y = chart.chartArea.bottom + 8;
                                    ctx.fillText(value + ' day' + (value !== 1 ? 's' : ''), x, y);
                                }
                            });
                        });
                    }
                }
            }
        });
    }

    // Initialize leave management event handlers
    $(document).ready(function() {
        // Add change event listener to user dropdown
        $('#leaveUserSelect').on('change', function() {
            loadLeaveData();
        });
        
        // Add change event listener to year dropdown
        $('#leaveYearSelect').on('change', function() {
            loadLeaveData();
        });
        
        // Auto-load data for the default selected user (logged-in user)
        if ($('#leaveUserSelect').val()) {
            loadLeaveData();
        }
    });


</script>
<!-- Show taken leave -->
<script>
    function showTakenLeaveTable() {
        document.getElementById('totalTakenLeaveTable').style.display = 'block';
    }

    function resetTakenLeaveTable() {
        document.getElementById('totalTakenLeaveTable').style.display = 'none';
    }
</script>


<!-- Professional Analytics Dashboard JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize analytics dashboard
    initializeAnalytics();
    
    // Enhanced animation delays to cards
    const cards = document.querySelectorAll('.dashboard-card, .quick-stat-card, .financial-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.08}s`;
    });

    // Professional hover effects to stat items
    const statItems = document.querySelectorAll('.stat-item');
    statItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px) scale(1.02)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Enhanced click effects to buttons
    const buttons = document.querySelectorAll('.btn-gradient, .btn-outline-gradient');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Create enhanced ripple effect
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // Professional scroll animations with enhanced options
    const observerOptions = {
        threshold: 0.15,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                // Add staggered animation for child elements
                const children = entry.target.querySelectorAll('.stat-item, .analytics-metric');
                children.forEach((child, index) => {
                    child.style.animationDelay = `${index * 0.1}s`;
                });
            }
        });
    }, observerOptions);

    // Observe all cards for scroll animations
    cards.forEach(card => {
        observer.observe(card);
    });

    // Hide any time/date displays that might still be showing (but NOT in dashboard header)
    function hideTimeDisplays() {
        const elements = document.querySelectorAll('.fw-bold.text-dark.fs-6, .text-muted');
        elements.forEach(element => {
            // Skip elements that are inside the dashboard header
            if (element.closest('.dashboard-header')) {
                return; // Don't hide time elements in dashboard header
            }
            
            const text = element.textContent;
            if (text.includes('Monday') || text.includes('September') || text.includes('2025') || 
                text.includes('UTC') || text.includes('13:') || text.includes('14:') || 
                text.includes('15:') || text.includes('16:') || text.includes('17:') ||
                text.includes('18:') || text.includes('19:') || text.includes('20:') ||
                text.includes('21:') || text.includes('22:') || text.includes('23:') ||
                text.includes('00:') || text.includes('01:') || text.includes('02:') ||
                text.includes('03:') || text.includes('04:') || text.includes('05:') ||
                text.includes('06:') || text.includes('07:') || text.includes('08:') ||
                text.includes('09:') || text.includes('10:') || text.includes('11:') ||
                text.includes('12:')) {
                element.style.display = 'none';
            }
        });
    }
    
    // Hide time displays immediately and on any updates
    hideTimeDisplays();
    setInterval(hideTimeDisplays, 1000);
    
    // Update time display in real-time
    function updateTimeDisplay() {
        const now = new Date();
        const dateElement = document.querySelector('.fw-bold.text-dark.fs-6');
        const timeElement = document.querySelector('.text-muted');
        
        if (dateElement) {
            dateElement.textContent = now.toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }
        
        if (timeElement) {
            timeElement.textContent = now.toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            }) + ' UTC';
        }
    }
    
    // Update time immediately and then every second
    updateTimeDisplay();
    setInterval(updateTimeDisplay, 1000);
    
    // Fix profile image 404 errors
    function fixProfileImages() {
        const profileImages = document.querySelectorAll('img[src*="admin-images"]');
        const defaultImage = '{{ asset("upload/default.jpg") }}';
        
        profileImages.forEach(img => {
            // Add error handling for each profile image
            img.addEventListener('error', function() {
                console.log('Profile image not found, using default:', this.src);
                this.src = defaultImage;
                this.style.opacity = '0.8'; // Slightly dimmed to indicate it's a fallback
            });
            
            // Add loading state
            img.addEventListener('load', function() {
                this.style.opacity = '1';
            });
        });
    }
    
    // Initialize profile image fixes
    fixProfileImages();
    
    // Clear any inline display:none styles from time elements in dashboard header
    function clearTimeDisplayStyles() {
        const dashboardHeader = document.querySelector('.dashboard-header');
        if (dashboardHeader) {
            const timeElements = dashboardHeader.querySelectorAll('.fw-bold.text-dark.fs-6, .text-muted');
            timeElements.forEach(element => {
                if (element.style.display === 'none') {
                    element.style.display = '';
                    console.log('Restored time display in dashboard header');
                }
            });
        }
    }
    
    // Clear styles immediately and after a short delay
    clearTimeDisplayStyles();
    setTimeout(clearTimeDisplayStyles, 100);

    
         // Initialize performance chart
     initializePerformanceChart();
     
     // Initialize financial chart
     initializeFinancialChart();
 });

// Analytics Functions
function initializeAnalytics() {
    console.log('Analytics Dashboard Initialized');
    // Add any additional analytics initialization here
}

function refreshAnalytics() {
    // Show loading state
    const refreshBtn = event.target.closest('button');
    const originalContent = refreshBtn.innerHTML;
    refreshBtn.innerHTML = '<i class="bi bi-arrow-clockwise spin"></i> Refreshing...';
    refreshBtn.disabled = true;
    
    // Simulate refresh delay
    setTimeout(() => {
        refreshBtn.innerHTML = originalContent;
        refreshBtn.disabled = false;
        
        // Show success notification
        showNotification('Analytics refreshed successfully!', 'success');
    }, 2000);
}

function exportAnalytics() {
    // Show loading state
    const exportBtn = event.target.closest('button');
    const originalContent = exportBtn.innerHTML;
    exportBtn.innerHTML = '<i class="bi bi-download"></i> Exporting...';
    exportBtn.disabled = true;
    
    // Simulate export delay
    setTimeout(() => {
        exportBtn.innerHTML = originalContent;
        exportBtn.disabled = false;
        
        // Show success notification
        showNotification('Analytics exported successfully!', 'success');
    }, 3000);
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

function initializePerformanceChart() {
    const ctx = document.getElementById('performanceChart');
    if (!ctx) return;
    
    const performanceData = {
        labels: ['Completed', 'Pending', 'Available'],
        datasets: [{
            data: [{{ $totalBookings }}, {{ $activeAvailabilities }}, {{ $todayAvailableUsers }}],
            backgroundColor: [
                'rgba(40, 167, 69, 0.8)',
                'rgba(255, 193, 7, 0.8)',
                'rgba(23, 162, 184, 0.8)'
            ],
            borderColor: [
                'rgba(40, 167, 69, 1)',
                'rgba(255, 193, 7, 1)',
                'rgba(23, 162, 184, 1)'
            ],
            borderWidth: 2,
            hoverOffset: 4
        }]
    };
    
    new Chart(ctx, {
        type: 'doughnut',
        data: performanceData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#fff',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: true
                }
            }
        }
    });
}

// Financial Chart Functions
let financialChart = null;

function initializeFinancialChart() {
    const ctx = document.getElementById('financialChart');
    if (!ctx) {
        console.warn('Financial chart element not found');
        return;
    }
    
    const financialData = {
        labels: ['Total Revenue', 'Total Expenses', 'Monthly Revenue', 'Monthly Expenses'],
        datasets: [{
            label: 'Financial Overview',
            data: [
                {{ $Final }},
                {{ $totalExpense }},
                {{ $MonthlyFinal }},
                {{ $monthlyExpense }}
            ],
            backgroundColor: [
                'rgba(40, 167, 69, 0.8)',   // Green for revenue
                'rgba(220, 53, 69, 0.8)',   // Red for expenses
                'rgba(23, 162, 184, 0.8)',  // Blue for monthly revenue
                'rgba(255, 193, 7, 0.8)'    // Yellow for monthly expenses
            ],
            borderColor: [
                'rgba(40, 167, 69, 1)',
                'rgba(220, 53, 69, 1)',
                'rgba(23, 162, 184, 1)',
                'rgba(255, 193, 7, 1)'
            ],
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false,
        }]
    };
    
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    usePointStyle: true,
                    padding: 20,
                    font: {
                        size: 12,
                        weight: '600'
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.9)',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: '#fff',
                borderWidth: 1,
                cornerRadius: 8,
                displayColors: true,
                callbacks: {
                    label: function(context) {
                        return context.label + ': $' + context.parsed.y.toLocaleString();
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)',
                    drawBorder: false
                },
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    },
                    font: {
                        size: 12
                    }
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    font: {
                        size: 12
                    }
                }
            }
        },
        animation: {
            duration: 2000,
            easing: 'easeInOutQuart'
        }
    };
    
    financialChart = new Chart(ctx, {
        type: 'bar',
        data: financialData,
        options: chartOptions
    });
    
    // Chart type selector functionality
    document.getElementById('financialChartType').addEventListener('change', function() {
        const chartType = this.value;
        updateFinancialChartType(chartType);
    });
}

function updateFinancialChartType(chartType) {
    if (!financialChart) return;
    
    // Destroy existing chart
    financialChart.destroy();
    
    // Get the canvas context
    const ctx = document.getElementById('financialChart');
    
    const financialData = {
        labels: ['Total Revenue', 'Total Expenses', 'Monthly Revenue', 'Monthly Expenses'],
        datasets: [{
            label: 'Financial Overview',
            data: [
                {{ $Final }},
                {{ $totalExpense }},
                {{ $MonthlyFinal }},
                {{ $monthlyExpense }}
            ],
            backgroundColor: [
                'rgba(40, 167, 69, 0.8)',
                'rgba(220, 53, 69, 0.8)',
                'rgba(23, 162, 184, 0.8)',
                'rgba(255, 193, 7, 0.8)'
            ],
            borderColor: [
                'rgba(40, 167, 69, 1)',
                'rgba(220, 53, 69, 1)',
                'rgba(23, 162, 184, 1)',
                'rgba(255, 193, 7, 1)'
            ],
            borderWidth: 2,
            borderRadius: chartType === 'bar' ? 8 : 0,
            borderSkipped: false,
            tension: chartType === 'line' ? 0.4 : 0,
            fill: chartType === 'line' ? true : false,
        }]
    };
    
    let chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    usePointStyle: true,
                    padding: 20,
                    font: {
                        size: 12,
                        weight: '600'
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.9)',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: '#fff',
                borderWidth: 1,
                cornerRadius: 8,
                displayColors: true,
                callbacks: {
                    label: function(context) {
                        return context.label + ': $' + context.parsed.y.toLocaleString();
                    }
                }
            }
        },
        animation: {
            duration: 1000,
            easing: 'easeInOutQuart'
        }
    };
   
    if (chartType === 'doughnut') {
        chartOptions.cutout = '60%';
        chartOptions.plugins.legend.position = 'bottom';
    } else if (chartType === 'line') {
        chartOptions.scales = {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)',
                    drawBorder: false
                },
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    },
                    font: { size: 12 }
                }
            },
            x: {
                grid: { display: false },
                ticks: { font: { size: 12 } }
            }
        };
    } else {
        chartOptions.scales = {
     l       y:  {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)',
                    drawBorder: false
                },
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    },
                    font: { size: 12 }
                }
            },
            x: {
                grid: { display: false },
                ticks: { font: { size: 12 } }
            }
        };
    }
    
    financialChart = new Chart(ctx, {
        type: chartType,
        data: financialData,
        options: chartOptions
    });
}



// Professional CSS for subtle effects
const style = document.createElement('style');
style.textContent = `
    .btn-gradient, .btn-outline-gradient {
        position: relative;
        overflow: hidden;
    }
    
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transform: scale(0);
        animation: ripple-animation 0.4s ease-out;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(3);
            opacity: 0;
        }
    }
    
    .dashboard-card, .quick-stat-card, .financial-card {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.4s ease;
    }
    
    .dashboard-card.fade-in, .quick-stat-card.fade-in, .financial-card.fade-in {
        opacity: 1;
        transform: translateY(0);
    }
    
    .fade-in {
        animation: fadeIn 0.4s ease-out;
    }
    
    @keyframes fadeIn {
        from { 
            opacity: 0; 
            transform: translateY(20px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }
    
    .slide-in {
        animation: slideIn 0.6s ease-out;
    }
    
    @keyframes slideIn {
        from { 
            transform: translateX(-30px); 
            opacity: 0; 
        }
        to { 
            transform: translateX(0); 
            opacity: 1; 
        }
    }
    
    
`;
document.head.appendChild(style);
</script>

@endsection


