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
  .last-updated { font-size: 0.9rem; color: rgba(255,255,255,0.85); margin-top: .5rem; }
  .refresh-btn { background: rgba(255,255,255,0.15); border: none; padding: 4px 10px; border-radius: 6px; color: white; cursor: pointer; font-size: 0.85rem; margin-left: 10px; transition: background 0.3s ease; }
  .refresh-btn:hover { background: rgba(255,255,255,0.3); }
  .stat-card { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.05); position: relative; transition: all 0.3s ease; }
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
  table.recent-table th, table.recent-table td { font-size: 0.9rem; }
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

  {{-- Counters --}}
  <div class="row g-3">
    <div class="col-md-4 col-xl-2"><div class="stat-card bg-gradient-1"><h3 id="totalQuotes">0</h3><p>Total Quotes</p><i class="bi bi-file-earmark-text stat-icon"></i></div></div>
    <div class="col-md-4 col-xl-2"><div class="stat-card bg-gradient-2"><h3 id="pendingQuotes">0</h3><p>Pending Payment</p><i class="bi bi-hourglass-split stat-icon"></i></div></div>
    <div class="col-md-4 col-xl-2"><div class="stat-card bg-gradient-3"><h3 id="completedQuotes">0</h3><p>Paid</p><i class="bi bi-check2-circle stat-icon"></i></div></div>
    <div class="col-md-4 col-xl-2"><div class="stat-card bg-gradient-4"><h3 id="users">0</h3><p>Users</p><i class="bi bi-people stat-icon"></i></div></div>
    <div class="col-md-4 col-xl-2"><div class="stat-card bg-gradient-5"><h3 id="admins">0</h3><p>Admins</p><i class="bi bi-shield-lock stat-icon"></i></div></div>
    <div class="col-md-4 col-xl-2"><div class="stat-card bg-gradient-6"><h3 id="pricingRules">0</h3><p>Pricing Rules</p><i class="bi bi-gear stat-icon"></i></div></div>
  </div>

  {{-- Charts Row 1 --}}
  <div class="row mt-4">
    <div class="col-lg-6">
      <div class="white_card">
        <div class="white_card_header"><h5>Quotes Breakdown by Status</h5></div>
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

  {{-- Charts Row 2 --}}
  <div class="row mt-4">
    <div class="col-lg-6">
      <div class="white_card">
        <div class="white_card_header"><h5>Quotes by Language</h5></div>
        <div class="white_card_body"><canvas id="languageChart"></canvas></div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="white_card">
        <div class="white_card_header"><h5>Monthly Quotes Trend</h5></div>
        <div class="white_card_body"><canvas id="monthlyChart"></canvas></div>
      </div>
    </div>
  </div>

  {{-- Pricing Levels --}}
  <div class="col-lg-12 mt-4">
    <div class="white_card">
      <div class="white_card_header"><h5>Users by Pricing Levels (TF & PF)</h5></div>
      <div class="white_card_body"><canvas id="pricingChart" height="120"></canvas></div>
    </div>
  </div>

  {{-- Recent Quotes Table --}}
  <div class="col-lg-12 mt-4">
    <div class="white_card">
      <div class="white_card_header"><h5>Recent Quotes (Grouped)</h5></div>
      <div class="white_card_body">
        <table class="table table-striped recent-table">
          <thead>
            <tr>
              <th>Invoice Group</th>
              <th>Region(s)</th>
              <th>Service</th>
              <th>Status</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody id="recentQuotesTable"></tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let quotesChart, jurisdictionChart, languageChart, monthlyChart, pricingChart;

function loadDashboardData(){
    $.get("{{ route('admin.dashboard.data') }}", function(res){

        // Counters
        $("#totalQuotes").text(res.stats.totalQuotes);
        $("#pendingQuotes").text(res.stats.pendingQuotes);
        $("#completedQuotes").text(res.stats.completedQuotes);
        $("#users").text(res.stats.users);
        $("#admins").text(res.stats.admins);
        $("#pricingRules").text(res.stats.pricingRules);

        // Recent Quotes Table
        let rows = '';
        res.recentQuotes.forEach(q=>{
            rows += `<tr>
              <td>${q.invoice_group}</td>
              <td>${q.regions}</td>
              <td>${q.service}</td>
              <td><span class="badge bg-${q.status=='paid'?'success':(q.status=='pending_payment'?'warning':'info')}">${q.status}</span></td>
              <td>${q.created_at}</td>
            </tr>`;
        });
        $("#recentQuotesTable").html(rows || '<tr><td colspan="5" class="text-center text-muted">No quotes</td></tr>');

        // Reset charts
        [quotesChart, jurisdictionChart, languageChart, monthlyChart, pricingChart].forEach(c=>c && c.destroy());

        // Quotes Breakdown
        quotesChart = new Chart(document.getElementById('quotesChart'), {
            type: 'doughnut',
            data: {
                labels: ['Pending Payment','Paid','Quoted'],
                datasets: [{
                    data: [res.stats.pendingQuotes,res.stats.completedQuotes,res.stats.quotedQuotes],
                    backgroundColor: ['#ffc107','#28a745','#17a2b8']
                }]
            },
            options: { plugins:{legend:{position:'bottom'}} }
        });

        // Jurisdiction
        jurisdictionChart = new Chart(document.getElementById('jurisdictionChart'), {
            type: 'bar',
            data: { labels: Object.keys(res.jurisdictions), datasets:[{ data:Object.values(res.jurisdictions), backgroundColor:'#4F708E' }] },
            options: { scales:{y:{beginAtZero:true}} }
        });

        // Languages
        languageChart = new Chart(document.getElementById('languageChart'), {
            type: 'pie',
            data: { labels: Object.keys(res.languages), datasets:[{ data:Object.values(res.languages), backgroundColor:['#6f42c1','#20c997','#fd7e14','#0dcaf0'] }] },
            options: { plugins:{legend:{position:'bottom'}} }
        });

        // Monthly Trend
        monthlyChart = new Chart(document.getElementById('monthlyChart'), {
            type: 'line',
            data: { labels: Object.keys(res.monthly), datasets:[{ label:'Quotes', data:Object.values(res.monthly), borderColor:'#4F708E', fill:true, backgroundColor:'rgba(79,112,142,0.2)' }] },
            options: { scales:{y:{beginAtZero:true}} }
        });

        // Pricing Levels
        let labels = res.pricingLevels.map(l => `${l.kind} - ${l.label}`);
        let data = res.pricingLevels.map(l => l.users);
        let colors = res.pricingLevels.map(l => l.kind === 'TF' ? '#4F708E' : '#28a745');

        pricingChart = new Chart(document.getElementById('pricingChart'), {
            type: 'bar',
            data: { labels: labels, datasets:[{ label:'Users', data:data, backgroundColor:colors }] },
            options: { scales:{y:{beginAtZero:true}}, plugins:{legend:{display:false}} }
        });

        // Update time
        $("#lastUpdated").text(new Date().toLocaleTimeString());
    });
}

$(document).ready(function(){
    loadDashboardData();
    setInterval(loadDashboardData, 30000);
    $("#refreshNow").click(loadDashboardData);
});
</script>
@endsection
