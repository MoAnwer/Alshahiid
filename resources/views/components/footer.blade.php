
  <script src="{{ asset('asset/js/html2canvas.min.js')}}"></script>
  <script src="{{ asset('asset/js/jquery.min.js')}}"></script>
  <script src="{{ asset('asset/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('asset/js/jquery.easing.min.js')}}"></script>
  <script src="{{ asset('asset/js/admin.min.js')}}"></script>
  <script type="text/javascript">
      function printTable() 
      {
        let table = document.querySelector('.table-responsive');
        // let th = document.querySelectorAll('.table-responsive thead th');

        // th.foreach(th => {
        //     th.style.direction = "ltr";
        // });

        html2canvas(table, {
            'scale': 2,
            'useCORS': true,
        }).then(canvas => {
            let imageDate = canvas.toDataURL('image/png');
            let newWindow = window.open(document.title);
            newWindow.document.write('<img src="' + imageDate + '" style="width:100%; ">')
            newWindow.document.close();
            setTimeout(() => {
                newWindow.print();
            }, 200);
        });
      }

      function  printContainer() 
      {
            let container = document.querySelector('#printArea');

            html2canvas(container, {
                'scale': 2,
                'useCORS': true,
            }).then(canvas => {
                let imageDate = canvas.toDataURL('image/png');
                let newWindow = window.open("");
                newWindow.document.write('<img src="' + imageDate + '" style="width:100%; ">')
                newWindow.document.close();
                setTimeout(() => {
                    newWindow.print();
                }, 200);
            });
      }
  </script>
</body>
</html>