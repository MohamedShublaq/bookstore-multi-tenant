 <script src="{{ asset('assets/Dashboard/vendors/js/vendors.min.js') }}" type="text/javascript"></script>
 <script src="{{ asset('assets/Dashboard/vendors/js/charts/chart.min.js') }}" type="text/javascript"></script>
 <script src="{{ asset('assets/Dashboard/js/core/app-menu.js') }}" type="text/javascript"></script>
 <script src="{{ asset('assets/Dashboard/js/core/app.js') }}" type="text/javascript"></script>
 <script src="{{ asset('assets/Dashboard/js/scripts/customizer.js') }}" type="text/javascript"></script>
 <script src="{{ asset('assets/Dashboard/js/scripts/pages/dashboard-crypto.js') }}" type="text/javascript"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 {{-- For Delete --}}
 <script>
     document.addEventListener('DOMContentLoaded', function() {
         document.addEventListener('click', function(e) {
             if (e.target.closest('.btn-delete')) {
                 let btn = e.target.closest('.btn-delete');
                 let url = btn.dataset.url;

                 Swal.fire({
                     title: 'Are you sure?',
                     text: "This action cannot be undone!",
                     icon: 'warning',
                     showCancelButton: true,
                     confirmButtonColor: '#3085d6',
                     cancelButtonColor: '#d33',
                     confirmButtonText: 'Yes, delete it!'
                 }).then((result) => {
                     if (result.isConfirmed) {
                         let form = document.createElement('form');
                         form.method = 'POST';
                         form.action = url;

                         let token = document.createElement('input');
                         token.type = 'hidden';
                         token.name = '_token';
                         token.value = "{{ csrf_token() }}";
                         form.appendChild(token);

                         let method = document.createElement('input');
                         method.type = 'hidden';
                         method.name = '_method';
                         method.value = 'DELETE';
                         form.appendChild(method);

                         document.body.appendChild(form);
                         form.submit();
                     }
                 });
             }
         });
     });
 </script>
 {{-- For Change Status --}}
 <script>
     document.addEventListener('DOMContentLoaded', function() {
         document.addEventListener('click', function(e) {
             if (e.target.closest('.btn-status')) {
                 let btn = e.target.closest('.btn-status');
                 let url = btn.dataset.url;

                 Swal.fire({
                     title: 'Are you sure?',
                     icon: 'warning',
                     showCancelButton: true,
                     confirmButtonColor: '#3085d6',
                     cancelButtonColor: '#d33',
                     confirmButtonText: 'Yes'
                 }).then((result) => {
                     if (result.isConfirmed) {
                         let form = document.createElement('form');
                         form.method = 'POST';
                         form.action = url;

                         let token = document.createElement('input');
                         token.type = 'hidden';
                         token.name = '_token';
                         token.value = "{{ csrf_token() }}";
                         form.appendChild(token);

                         let method = document.createElement('input');
                         method.type = 'hidden';
                         method.name = '_method';
                         method.value = 'PATCH';
                         form.appendChild(method);

                         document.body.appendChild(form);
                         form.submit();
                     }
                 });
             }
         });
     });
 </script>
 {{-- For Reset Password --}}
 <script>
     document.addEventListener('DOMContentLoaded', function() {
         document.addEventListener('click', function(e) {
             if (e.target.closest('.btn-reset')) {
                 let btn = e.target.closest('.btn-reset');
                 let url = btn.dataset.url;

                 Swal.fire({
                     title: 'Are you sure?',
                     text: "Password will be 123456789",
                     icon: 'warning',
                     showCancelButton: true,
                     confirmButtonColor: '#3085d6',
                     cancelButtonColor: '#d33',
                     confirmButtonText: 'Yes'
                 }).then((result) => {
                     if (result.isConfirmed) {
                         let form = document.createElement('form');
                         form.method = 'POST';
                         form.action = url;

                         let token = document.createElement('input');
                         token.type = 'hidden';
                         token.name = '_token';
                         token.value = "{{ csrf_token() }}";
                         form.appendChild(token);

                         let method = document.createElement('input');
                         method.type = 'hidden';
                         method.name = '_method';
                         method.value = 'PATCH';
                         form.appendChild(method);

                         document.body.appendChild(form);
                         form.submit();
                     }
                 });
             }
         });
     });
 </script>
 @stack('js')
