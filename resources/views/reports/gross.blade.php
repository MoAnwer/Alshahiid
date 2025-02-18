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
          <div class="d-flex justify-content-between align-items-center px-3">
            <x-print-btn />
          </div>
        </div>
        

        
    
        <hr>
        
        <x-search-form />
        <div id="printArea">
		      <x-table>
			     <x-slot:head>
              <th>الاجمالي العام</th>
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
                <td>الإجمالي العام</td>
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

              <caption class="text-primary">
                 الإجمالي العام
                 
                 @if(request()->query('type') != 'all')
                   {{ request()->query('type') }}
                 @endif
   
                @if(request()->query('sector') == 'all' || is_null(request()->query('sector')))
                  كل القطاعات
                @else
                  {{ request()->query('sector') }}
                @endif

                @if(request()->query('locality') == 'all')
                كل المحليات
                @else
                  {{ request()->query('locality') }}
                @endif

               @empty(!request()->query('year'))
                {{ 'سنة ' . request()->query('year')  . (request()->query('month') != '' ?  ' شهر ' . request()->query('month') : ' لكل الشهور     ')}}
                @endempty


               </caption>
            </x-slot:body>

          </x-table>
        </div>
    </div>
  </div>

  @include('components.footer')