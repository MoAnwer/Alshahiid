@include('components.header', ['page_title' => 'تقرير الاجمالي العام'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>تقرير الاجمالي العام</h4>
        </div>
    
        
		      <x-table>
			     <x-slot:head>
              <th><b>الاجمالي العام</b></th>
              <th>مطلوب</th>
              <th>منفذ</th>
			        <th>النسبة</th>
              <th>التقديري</th>
              <th>من داخل المنظمة</th>
              <th>من خارج المنظمة</th>
              <th>الاجمالي الكلي</th>
            </x-slot:head>

            <x-slot:body>
              <tr>
                <th>الإجمالي العام</th>
                <td>{{ $report['need'] }} </td>
                <td>{{ $report['done'] }} </td>
                <td>
                  @if( $report['done'] > 0 &&  $report['need'] )
                    {{ round(@($report['done'] / $report['need'] ) * 100, 2) }}%
                  @else
                    0
                  @endif
                </td>
                <td>{{ number_format($report['budget']) }} </td>
                <td>{{ number_format($report['budgetFromOrg']) }} </td>
                <td>{{ number_format($report['budgetOurOfOrg']) }} </td>
                <td>{{ number_format($report['totalMoney']) }} </td>
              </tr>
            </x-slot:body>

          </x-table>
          <caption>
            <span class="text-danger">*ملاحظة :</span> قد لا تظهر التعديلات الا بعد 10 دقائق
          </caption>
    </div>
  </div>

  @include('components.footer')