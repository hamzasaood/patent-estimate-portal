@extends('admin.layout.app')
@section('title','Admin Dashboard')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
  .dashboard-header {
    background: linear-gradient(135deg, #4F708E, #6C8EA5);
    color: white;
    padding: 2rem;
    border-radius: 12px;
    margin-bottom: 2rem;
  }
  .dashboard-header h3 { font-weight: 700; }
  .last-updated {
    font-size: 0.9rem;
    color: rgba(255,255,255,0.85);
    margin-top: .5rem;
  }
  .refresh-btn {
    background: rgba(255,255,255,0.15);
    border: none;
    padding: 4px 10px;
    border-radius: 6px;
    color: white;
    cursor: pointer;
    font-size: 0.85rem;
    margin-left: 10px;
    transition: background 0.3s ease;
  }
  .refresh-btn:hover {
    background: rgba(255,255,255,0.3);
  }
  .stat-card { background: white; border-radius: 12px; padding: 1.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05); position: relative; transition: all 0.3s ease; }
  .stat-card:hover { transform: translateY(-5px); box-shadow: 0 8px 18px rgba(0,0,0,0.12); }
  .stat-card h3 { font-size: 1.8rem; margin-bottom: .5rem; color: #333; }
  .stat-card p { margin: 0; font-size: .9rem; color: #666; }
  .stat-icon { position: absolute; bottom: 10px; right: 10px; font-size: 2.5rem; opacity: 0.15; }
  .bg-gradient-1 { border-left: 5px solid #4F708E; }
  .bg-gradient-2 { border-left: 5px solid #ffc107; }
  .bg-gradient-3 { border-left: 5px solid #28a745; }
  .bg-gradient-4 { border-left: 5px solid #17a2b8; }
  .bg-gradient-5 { border-left: 5px solid #6f42c1; }
  .bg-gradient-6 { border-left: 5px solid #dc3545; }
  .white_card { background: #fff; border-radius: 12px; box-shadow: 0 3px 10px rgba(0,0,0,0.05); padding: 1rem; }
  .white_card_header h5 { font-weight: 600; margin-bottom: 1rem; }
  #recentQuotes li, #recentLogs li {
    border: none;
    border-left: 4px solid #4F708E;
    margin-bottom: 8px;
    border-radius: 6px;
    background: #f9fafc;
  }
</style>

<div class="container-fluid px-0">

  {{-- Header --}}
  <div class="dashboard-header d-flex justify-content-between align-items-center">
    <div>
      <h3>📊 Welcome back, Admin!</h3>
      <p class="mb-0">Here’s what’s happening on your portal today.</p>
      <div class="last-updated">
        Last Updated: <span id="lastUpdated">--:--:--</span>
        <button class="refresh-btn" id="refreshNow"><i class="bi bi-arrow-repeat"></i> Refresh</button>
      </div>
    </div>
    <div><i class="bi bi-speedometer2 fs-1"></i></div>
  </div>

  {{-- Stats --}}
  <div class="row g-3">
    <div class="col-md-4 col-xl-2"><div class="stat-card bg-gradient-1"><h3 id="totalQuotes">0</h3><p>Total Quotes</p><i class="bi bi-file-earmark-text stat-icon"></i></div></div>
    <div class="col-md-4 col-xl-2"><div class="stat-card bg-gradient-2"><h3 id="pendingQuotes">0</h3><p>Pending</p><i class="bi bi-hourglass-split stat-icon"></i></div></div>
    <div class="col-md-4 col-xl-2"><div class="stat-card bg-gradient-3"><h3 id="completedQuotes">0</h3><p>Completed</p><i class="bi bi-check2-circle stat-icon"></i></div></div>
    <div class="col-md-4 col-xl-2"><div class="stat-card bg-gradient-4"><h3 id="users">0</h3><p>Users</p><i class="bi bi-people stat-icon"></i></div></div>
    <div class="col-md-4 col-xl-2"><div class="stat-card bg-gradient-5"><h3 id="admins">0</h3><p>Admins</p><i class="bi bi-shield-lock stat-icon"></i></div></div>
    <div class="col-md-4 col-xl-2"><div class="stat-card bg-gradient-6"><h3 id="pricingRules">0</h3><p>Pricing Rules</p><i class="bi bi-gear stat-icon"></i></div></div>
  </div>

  {{-- Charts --}}
  <div class="row mt-4">
    <div class="col-lg-6">
      <div class="white_card">
        <div class="white_card_header"><h5>Quotes Breakdown</h5></div>
        <div class="white_card_body"><canvas id="quotesChart"></canvas></div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="white_card">
        <div class="white_card_header"><h5>Estimates by Jurisdiction</h5></div>
        <div class="white_card_body"><canvas id="jurisdictionChart"></canvas></div>
      </div>
    </div>
  </div>

  {{-- Recent --}}
  <div class="row mt-4">
    <div class="col-lg-6">
      <div class="white_card">
        <div class="white_card_header"><h5>Recent Quotes</h5></div>
        <div class="white_card_body"><ul class="list-group" id="recentQuotes"></ul></div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="white_card">
        <div class="white_card_header"><h5>Recent Admin Actions</h5></div>
        <div class="white_card_body"><ul class="list-group" id="recentLogs"></ul></div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let quotesChart, jurisdictionChart;

function loadDashboardData(){
    $.get("{{ route('admin.dashboard.data') }}", function(res){

        // Stats
        $("#totalQuotes").text(res.stats.totalQuotes);
        $("#pendingQuotes").text(res.stats.pendingQuotes);
        $("#completedQuotes").text(res.stats.completedQuotes);
        $("#users").text(res.stats.users);
        $("#admins").text(res.stats.admins);
        $("#pricingRules").text(res.stats.pricingRules);

        // Recent Quotes
        let rq = '';
        res.recentQuotes.forEach(q=>{
            rq += `<li class="list-group-item d-flex justify-content-between">
              <span>#${q.id} - ${q.application_type}</span>
              <span class="badge bg-${q.status=='completed'?'success':(q.status=='pending'?'warning':'danger')}">${q.status}</span>
            </li>`;
        });
        $("#recentQuotes").html(rq || '<li class="list-group-item">No recent quotes</li>');

        // Recent Logs
        /*
        let rl = '';
        res.recentLogs.forEach(l=>{
            rl += `<li class="list-group-item d-flex justify-content-between">
              <span>${l.admin_name} updated ${l.module}</span>
              <small class="text-muted">${l.created_at}</small>
            </li>`;
        });
        $("#recentLogs").html(rl || '<li class="list-group-item">No recent logs</li>');

        */

        // Update Charts
        if(quotesChart){ quotesChart.destroy(); }
        if(jurisdictionChart){ jurisdictionChart.destroy(); }

        quotesChart = new Chart(document.getElementById('quotesChart'), {
            type: 'doughnut',
            data: {
                labels: ['Pending','Completed','Rejected'],
                datasets: [{
                    data: [res.stats.pendingQuotes,res.stats.completedQuotes,res.stats.rejectedQuotes],
                    backgroundColor: ['#ffc107','#28a745','#dc3545']
                }]
            },
            options: { plugins:{legend:{position:'bottom'}} }
        });

        jurisdictionChart = new Chart(document.getElementById('jurisdictionChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(res.jurisdictions),
                datasets: [{
                    label: 'Quotes',
                    data: Object.values(res.jurisdictions),
                    backgroundColor: '#4F708E'
                }]
            },
            options: { scales:{y:{beginAtZero:true}} }
        });

        // Update "Last Updated"
        let now = new Date();
        let timeString = now.toLocaleTimeString();
        $("#lastUpdated").text(timeString);
    });
}

$(document).ready(function(){
    loadDashboardData(); // Initial load
    setInterval(loadDashboardData, 30000); // Auto-refresh every 30s
    $("#refreshNow").click(loadDashboardData); // Manual refresh
});
</script>
@endsection
