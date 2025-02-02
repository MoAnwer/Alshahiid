@include('components.header', ['page_title' => 'تقارير المشروعات'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>تقارير المشروعات</h4>
        </div>

        <div class="search-form">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row">
              
              <div class="col-6">
                <label>القطاع :</label>
                <div class="form-group">
                    <select name="sector" class="form-select">
                      <option value="القطاع الشرقي"  @selected(request('sector') == 'القطاع الشرقي')>القطاع الشرقي</option>
                      <option value="القطاع الشمالي" @selected(request('sector') == 'القطاع الشمالي')>القطاع الشمالي</option>
                      <option value="القطاع الغربي"  @selected(request('sector') == 'القطاع الغربي')>القطاع الغربي</option>
                    </select>
                  </div>
              </div>

              <div class="col-5">
                  <label>المحلية: </label>
                  <div class="form-group">
                    <select name="locality" class="form-select">
                      @foreach(['كسلا','خشم القربة','همشكوريب','تلكوك وتوايت','شمال الدلتا','اروما','ريفي كسلا','غرب كسلا','محلية المصنع محطة ود الحليو','نهر عطبرة','غرب كسلا','حلفا الجديدة'] as $locality)
                        <option value="{{ $locality }}" @selected(request('locality') == $locality)>{{ $locality }}</option>
                        @endforeach
                      </select>
                  </div>
                </div>

              <div class="col-1 mt-3 d-flex align-items-center flex-column justify-content-center">
                <button class="btn py-4 btn-primary active form-control ">
                  <i class="fas fa-search ml-2"></i>
                  بحث 
                </button>
              </div>

              </form>

            </div>
        </div> {{-- search form --}}
          
        
		      <x-table>
			     <x-slot:head>
              <th>نوع الخدمة</th>
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
                <td>فردية جديدة</td>
                <td>{{ ($report->get('member')['need'][0]->count ?? 0) }}</td>
                <td>{{ ($report->get('member')['done'][0]->count ?? 0) }}</td>
                <td>{{ $report->get('precentages')['member'] . '%'}}</td>

                <td>{{ number_format(($report->get('member')['need'][0]->totalBudget ?? 0) +  ($report->get('member')['done'][0]->totalBudget ?? 0)) }}</td>

                <td>{{ number_format(($report->get('member')['need'][0]->budget_from_org ?? 0)  +  ($report->get('member')['done'][0]->budget_from_org ?? 0)) }}</td>

                <td>{{ number_format(($report->get('member')['need'][0]->budget_out_of_org ?? 0) +  ($report->get('member')['done'][0]->budget_out_of_org ?? 0)) }}</td>

                <td>
                  {{  
                    number_format(
                        (($report->get('member')['need'][0]->budget_from_org ?? 0)  +  ($report->get('member')['done'][0]->budget_from_org ?? 0))
                        + (($report->get('member')['need'][0]->budget_out_of_org  ?? 0)+  ($report->get('member')['done'][0]->budget_out_of_org ?? 0))
                      )
                   }}
                </td>

              </tr>
              <tr>
                <td>جماعية جديدة</td>
                <td>{{ ($report->get('team')['need'][0]->count ?? 0) }}</td>
                <td>{{ ($report->get('team')['done'][0]->count ?? 0) }}</td>
                <td>{{ $report->get('precentages')['team']. '%'}}</td>

                <td>{{ number_format(($report->get('team')['need'][0]->totalBudget ?? 0) + ($report->get('team')['done'][0]->totalBudget ?? 0)) }}</td>

                <td>{{ number_format(($report->get('team')['need'][0]->budget_from_org ?? 0)  +  ($report->get('team')['done'][0]->budget_from_org ?? 0)) }}</td>

                <td>{{ number_format(($report->get('team')['need'][0]->budget_out_of_org ?? 0) +  ($report->get('team')['done'][0]->budget_out_of_org ?? 0)) }}</td>

                <td>{{  number_format((($report->get('team')['need'][0]->budget_from_org ?? 0)  + ( $report->get('team')['done'][0]->budget_from_org ?? 0)) + (($report->get('team')['need'][0]->budget_out_of_org ?? 0) + ( $report->get('team')['done'][0]->budget_out_of_org ?? 0))) }} </td>

              </tr>

              <tr>
                <td>الاجمالي</td>  
                <td>{{ ($report->get('member')['need'][0]->count ?? 0) + ($report->get('team')['need'][0]->count ?? 0) }}</td>
                <td>{{ ($report->get('member')['done'][0]->count ?? 0) + ($report->get('team')['done'][0]->count ?? 0)}}</td>
                <td>
                  @if(@$report->get('member')['done'][0]->count > 0) 
                  {{ 
                  round( (
                    ( ($report->get('member')['done'][0]->count ?? 0) + ($report->get('team')['done'][0]->count ?? 1) )
                    / 
                    ( ($report->get('member')['need'][0]->count ?? 0) + ($report->get('team')['need'][0]->count ?? 1) )
                   ) * 100, 1)
                  . '%'
                 }}
                 @else 
                 0%
                 @endif
               </td>

                <td>{{ number_format( ($report->get('totals')['total_budget'] ?? 0) ) }}</td>

                <td>{{ number_format( ($report->get('totals')['total_budget_from_org'] ?? 0) ) }}</td>

                <td>{{ number_format( ($report->get('totals')['total_budget_out_of_org'] ?? 0) ) }}</td>


                <td>{{  number_format( ($report->get('totals')['total_money'] ?? 0) ) }}</td>

              </tr>
            <caption>{{ request()->query('sector') ?? ''}}</caption>

			    </x-slot:body>

		    </x-table>

      </div>
    </div>

  @include('components.footer')