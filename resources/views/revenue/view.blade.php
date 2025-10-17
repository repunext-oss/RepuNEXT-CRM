@extends('admin.admin_master')
@section('admin')
<style>
    .detail-card {
        background: #ffffff;
        border-radius: 0.75rem;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid #e1e3ea;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .detail-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #181c32;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 3px solid #009ef7;
        display: flex;
        align-items: center;
    }
    
    .detail-title .svg-icon {
        margin-right: 0.75rem;
    }
    
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }
    
    .detail-row {
        display: flex;
        flex-direction: column;
        padding: 1rem 0;
        border-bottom: 1px solid #f1f3f6;
    }
    
    .detail-row:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        font-weight: 600;
        color: #5e6278;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }
    
    .detail-value {
        color: #181c32;
        font-weight: 600;
        font-size: 1rem;
        word-break: break-word;
    }
    
    .amount-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #00a651;
    }
    
    .status-badge {
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .badge-success {
        background-color: #e8f5e8;
        color: #00a651;
        border: 1px solid #c3e6cb;
    }
    
    .header-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 0.75rem;
        margin-bottom: 2rem;
    }
    
    .header-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .breadcrumb {
        background: none;
        padding: 0;
        margin: 0;
    }
    
    .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
    }
    
    .breadcrumb-item a:hover {
        color: white;
    }
    
    .breadcrumb-item.active {
        color: white;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.6);
    }
    
    @media (max-width: 768px) {
        .detail-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .detail-card {
            padding: 1.5rem;
        }
        
        .header-section {
            padding: 1.5rem;
        }
        
        .header-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			
			<!-- Header Section -->
			<div class="header-section">
				<h1 class="header-title">
					<span class="svg-icon svg-icon-2 me-3">
						<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
							<path d="M12 2L2 7L12 12L22 7L12 2Z" fill="currentColor"/>
							<path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</span>
					Revenue Details
				</h1>
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="{{route('dashboard')}}">Dashboard</a>
						</li>
						<li class="breadcrumb-item">
							<a href="{{route('revenue-expense.index')}}">Revenue & Expense</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">View Revenue</li>
					</ol>
				</nav>
			</div>

			<div class="row">
				<div class="col-lg-8"> 
					
					<!-- Basic Information Section -->
					<div class="detail-card">
						<div class="detail-title">
							<span class="svg-icon svg-icon-2 me-2">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z" fill="currentColor"/>
									<path d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM4 20H16V4H4V20Z" fill="currentColor"/>
								</svg>
							</span>
							Basic Information
						</div>
						<div class="detail-grid">
							<div class="detail-row">
								<span class="detail-label">Revenue Name</span>
								<span class="detail-value">{{ $revenue->r_name ?? 'Not specified' }}</span>
							</div>
							<div class="detail-row">
								<span class="detail-label">Entry Date</span>
								<span class="detail-value">
									{{ $revenue->entry_date ? \Carbon\Carbon::parse($revenue->entry_date)->format('d-m-Y') : \Carbon\Carbon::parse($revenue->created_at)->format('d-m-Y') }}
								</span>
							</div>
							<div class="detail-row">
								<span class="detail-label">Created At</span>
								<span class="detail-value">{{ $revenue->created_at->format('d-m-Y H:i:s') }}</span>
							</div>
							<div class="detail-row">
								<span class="detail-label">Last Updated</span>
								<span class="detail-value">{{ $revenue->updated_at->format('d-m-Y H:i:s') }}</span>
							</div>
						</div>
					</div>

					<!-- Financial Details Section -->
					<div class="detail-card">
						<div class="detail-title">
							<span class="svg-icon svg-icon-2 me-2">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
								</svg>
							</span>
							Financial Details
						</div>
						<div class="detail-grid">
							<div class="detail-row">
								<span class="detail-label">Amount</span>
								<span class="detail-value amount-value">₹{{ number_format($revenue->amount, 2) }}</span>
							</div>
							<div class="detail-row">
								<span class="detail-label">Payment Method</span>
								<span class="detail-value">{{ $revenue->payment_method ?? 'Not specified' }}</span>
							</div>
						</div>
					</div>

					<!-- Category Information Section -->
					<div class="detail-card">
						<div class="detail-title">
							<span class="svg-icon svg-icon-2 me-2">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<path d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3ZM19 19H5V5H19V19Z" fill="currentColor"/>
									<path d="M14 17H7V15H14V17ZM17 13H7V11H17V13ZM17 9H7V7H17V9Z" fill="currentColor"/>
								</svg>
							</span>
							Category Information
						</div>
						<div class="detail-grid">
							<div class="detail-row">
								<span class="detail-label">Category</span>
								<span class="detail-value">{{ $revenue->category }}</span>
							</div>
							<div class="detail-row">
								<span class="detail-label">Subcategory</span>
								<span class="detail-value">{{ $revenue->subcategory ?? 'Not applicable' }}</span>
							</div>
						</div>
					</div>
				</div>

				<!-- Sidebar -->
				<div class="col-lg-4">
					<!-- System Information Section -->
					<div class="detail-card">
						<div class="detail-title">
							<span class="svg-icon svg-icon-2 me-2">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<path d="M12 2L2 7L12 12L22 7L12 2Z" fill="currentColor"/>
									<path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</span>
							System Information
						</div>
						<div class="detail-row">
							<span class="detail-label">Record ID</span>
							<span class="detail-value">#{{ $revenue->id }}</span>
						</div>
						<div class="detail-row">
							<span class="detail-label">Status</span>
							<span class="detail-value">
								<span class="status-badge badge-success">
									<span class="svg-icon svg-icon-5 me-1">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
											<path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
										</svg>
									</span>
									Active
								</span>
							</span>
						</div>
					</div>

					<!-- Quick Actions Card -->
					<div class="detail-card">
						<div class="detail-title">
							<span class="svg-icon svg-icon-2 me-2">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
								</svg>
							</span>
							Quick Actions
						</div>
						<div class="d-grid gap-2">
							<a href="{{ route('revenue.edit', $revenue) }}" class="btn btn-warning btn-lg">
								<span class="svg-icon svg-icon-2 me-2">
									<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16" fill="currentColor">
										<path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708L14.5 4.5l-3-3L12.146.146zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
									</svg>
								</span>
								Edit Revenue
							</a>
							<button type="button" class="btn btn-danger btn-lg" onclick="deleteRevenue({{ $revenue->id }})">
								<span class="svg-icon svg-icon-2 me-2">
									<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16" fill="currentColor">
										<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
										<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
									</svg>
								</span>
								Delete Revenue
							</button>
							<a href="{{ route('revenue-expense.index') }}" class="btn btn-light btn-lg">
								<span class="svg-icon svg-icon-2 me-2">
									<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16" fill="currentColor">
										<path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
									</svg>
								</span>
								Back to List
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function deleteRevenue(id) {
		Swal.fire({
			title: "Are you sure?",
			text: "You will not be able to recover this revenue record!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#d33",
			cancelButtonColor: "#3085d6",
			confirmButtonText: "Yes, delete it!",
			cancelButtonText: "Cancel"
		}).then((result) => {
			if (result.isConfirmed) {
				// Create a form to submit the DELETE request
				let form = document.createElement('form');
				form.method = 'POST';
				form.action = `/revenue/${id}`;
				
				// Add CSRF token
				let csrfInput = document.createElement('input');
				csrfInput.type = 'hidden';
				csrfInput.name = '_token';
				csrfInput.value = '{{ csrf_token() }}';
				form.appendChild(csrfInput);
				
				// Add method override for DELETE
				let methodInput = document.createElement('input');
				methodInput.type = 'hidden';
				methodInput.name = '_method';
				methodInput.value = 'DELETE';
				form.appendChild(methodInput);
				
				// Submit the form
				document.body.appendChild(form);
				form.submit();
			}
		});
	}
</script>
@endsection
