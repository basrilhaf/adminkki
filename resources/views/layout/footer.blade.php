
<script type="text/javascript">
	$(document).ready(function() {
		$('#logoutButton').on('click', function(e) {
			e.preventDefault();

			$.ajax({
				url: '{{ route("logout") }}',
				type: 'POST',
				data: {
					_token: $('meta[name="csrf-token"]').attr('content')
				},
				success: function(response) {
					window.location.href = '/login';
				},
				error: function(response) {
					console.log('Logout failed');
				}
			});
		});
	});
</script>
		
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
        
		<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Vendors Javascript(used for this page only)-->
		<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
		<!--end::Vendors Javascript-->
		<!--begin::Custom Javascript(used for this page only)-->
		<script src="{{ asset('assets/js/custom/apps/user-management/users/list/table.js') }}"></script>
		<script src="{{ asset('assets/js/custom/apps/user-management/users/list/export-users.js') }}"></script>
		<script src="{{ asset('assets/js/custom/apps/user-management/users/list/add.js') }}"></script>
		<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
		<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
		<script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
		<script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
		<script src="{{ asset('assets/js/custom/utilities/modals/create-campaign.js') }}"></script>
		<script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>