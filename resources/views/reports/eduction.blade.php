@include('components.header', ['page_title' => 'تقارير التعليم'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>تقارير التعليم</h4>
        </div>

        {{-- <div class="search-form">
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
        </div> search form --}}
        
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
            @php
            $totalNeed = 0;
            $totalDone = 0;
            $totalBudget = 0;
            $totalBudgetFromOrg = 0;
            $totalBudgetOutOfOrg = 0;
            $totalMoney = 0;
            @endphp
           <tr>
              <td>زي و أدوات</td>
              <td>
                @if (!@is_null($report->get('زي و أدوات')) && !@is_null($report->get('زي و أدوات')['مطلوب']))
                  {{ @$report->get('زي و أدوات')['مطلوب'][0]->count }}
                  @php($totalNeed += $report->get('زي و أدوات')['مطلوب'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (!@is_null($report->get('زي و أدوات')) && @isset($report->get('زي و أدوات')['منفذ']))
                  {{ @$report->get('زي و أدوات')['منفذ'][0]->count }}
                   @php($totalDone +=  $report->get('زي و أدوات')['منفذ'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (
                  !@is_null($report->get('زي و أدوات')) && !@is_null($report->get('زي و أدوات')['مطلوب']) && !@is_null($report->get('زي و أدوات')['منفذ'])
                  && $report->get('زي و أدوات')['منفذ'][0]->count > 0
                )
                  {{ round(($report->get('زي و أدوات')['منفذ'][0]->count  /  $report->get('زي و أدوات')['مطلوب'][0]->count) * 100, 1) . '%' }}
                @else
                  0%
                @endif
              </td>    
              <td>
                  {{ number_format((@$report->get('زي و أدوات')['منفذ'][0]->budget ?? 0) + (@$report->get('زي و أدوات')['مطلوب'][0]->budget ?? 0)) }}
                   @php($totalBudget += (@$report->get('زي و أدوات')['منفذ'][0]->budget ?? 0) + (@$report->get('زي و أدوات')['مطلوب'][0]->budget ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('زي و أدوات')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('زي و أدوات')['مطلوب'][0]->budget_from_org ?? 0)) }}
                   @php($totalBudgetFromOrg += (@$report->get('زي و أدوات')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('زي و أدوات')['مطلوب'][0]->budget_from_org ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('زي و أدوات')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('زي و أدوات')['مطلوب'][0]->budget_out_of_org ?? 0)) }}
                  @php($totalBudgetOutOfOrg += (@$report->get('زي و أدوات')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('زي و أدوات')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
              <td>
                  {{ 
                    (@$report->get('زي و أدوات')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('زي و أدوات')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('زي و أدوات')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('زي و أدوات')['مطلوب'][0]->budget_out_of_org ?? 0)
                  }}
                  @php($totalMoney += (@$report->get('زي و أدوات')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('زي و أدوات')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('زي و أدوات')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('زي و أدوات')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
           </tr>
            
           <tr>
              <td>رسوم دراسية</td>
              <td>
                @if (!@is_null($report->get('رسوم دراسية')) && !@is_null($report->get('رسوم دراسية')['مطلوب']))
                  {{ $report->get('رسوم دراسية')['مطلوب'][0]->count }}
                  @php($totalNeed += $report->get('رسوم دراسية')['مطلوب'][0]->count )
                @else
                  0
                @endif
              </td>
              <td>
                @if (!@is_null($report->get('رسوم دراسية')) && @isset($report->get('رسوم دراسية')['منفذ']))
                  {{ @$report->get('رسوم دراسية')['منفذ'][0]->count }}
                  @php($totalDone += @$report->get('رسوم دراسية')['منفذ'][0]->count )
                @else
                  0
                @endif
              </td>
              <td>
                @if (
                  !@is_null($report->get('رسوم دراسية')) && !@is_null($report->get('رسوم دراسية')['مطلوب']) && !@is_null($report->get('رسوم دراسية')['منفذ'])
                  && $report->get('رسوم دراسية')['منفذ'][0]->count > 0
                )
                  {{ round(($report->get('رسوم دراسية')['منفذ'][0]->count  /  $report->get('رسوم دراسية')['مطلوب'][0]->count) * 100, 1) . '%' }}
                @else
                  0%
                @endif
              </td>    
              <td>
                  {{ number_format((@$report->get('رسوم دراسية')['منفذ'][0]->budget ?? 0) + (@$report->get('رسوم دراسية')['مطلوب'][0]->budget ?? 0)) }}
                  @php($totalBudget += (@$report->get('رسوم دراسية')['منفذ'][0]->budget ?? 0) + (@$report->get('رسوم دراسية')['مطلوب'][0]->budget ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('رسوم دراسية')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('رسوم دراسية')['مطلوب'][0]->budget_from_org ?? 0)) }}
                  @php($totalBudgetFromOrg += (@$report->get('رسوم دراسية')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('رسوم دراسية')['مطلوب'][0]->budget_from_org ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('رسوم دراسية')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('رسوم دراسية')['مطلوب'][0]->budget_out_of_org ?? 0)) }}
                  @php($totalBudgetOutOfOrg += (@$report->get('رسوم دراسية')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('رسوم دراسية')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
              <td>
                  {{ 
                    (@$report->get('رسوم دراسية')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('رسوم دراسية')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('رسوم دراسية')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('رسوم دراسية')['مطلوب'][0]->budget_out_of_org ?? 0)
                  }}
                  @php($totalMoney +=  (@$report->get('رسوم دراسية')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('رسوم دراسية')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('رسوم دراسية')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('رسوم دراسية')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
           </tr>
            
           <tr>
              <td>تأهيل مهني</td>
              <td>
                @if (!@is_null($report->get('تأهيل مهني')) && !@is_null($report->get('تأهيل مهني')['مطلوب']))
                  {{ $report->get('تأهيل مهني')['مطلوب'][0]->count }}
                  @php($totalNeed += $report->get('تأهيل مهني')['مطلوب'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (!@is_null($report->get('تأهيل مهني')) && @isset($report->get('تأهيل مهني')['منفذ']))
                  {{ @$report->get('تأهيل مهني')['منفذ'][0]->count }}
                  @php($totalDone += @$report->get('تأهيل مهني')['منفذ'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (
                  !@is_null($report->get('تأهيل مهني')) && !@is_null($report->get('تأهيل مهني')['مطلوب']) && !@is_null($report->get('تأهيل مهني')['منفذ'])
                  && $report->get('تأهيل مهني')['منفذ'][0]->count > 0
                )
                  {{ round(($report->get('تأهيل مهني')['منفذ'][0]->count  /  $report->get('تأهيل مهني')['مطلوب'][0]->count) * 100, 1) . '%' }}
                @else
                  0%
                @endif
              </td>    
              <td>
                  {{ number_format((@$report->get('تأهيل مهني')['منفذ'][0]->budget ?? 0) + (@$report->get('تأهيل مهني')['مطلوب'][0]->budget ?? 0)) }}
                  @php($totalBudget += (@$report->get('تأهيل مهني')['منفذ'][0]->budget ?? 0) + (@$report->get('تأهيل مهني')['مطلوب'][0]->budget ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('تأهيل مهني')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('تأهيل مهني')['مطلوب'][0]->budget_from_org ?? 0)) }}
                  @php($totalBudgetFromOrg += (@$report->get('تأهيل مهني')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('تأهيل مهني')['مطلوب'][0]->budget_from_org ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('تأهيل مهني')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('تأهيل مهني')['مطلوب'][0]->budget_out_of_org ?? 0)) }}
                  @php($totalBudgetOutOfOrg += (@$report->get('تأهيل مهني')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('تأهيل مهني')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
              <td>
                  {{ 
                    (@$report->get('تأهيل مهني')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('تأهيل مهني')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('تأهيل مهني')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('تأهيل مهني')['مطلوب'][0]->budget_out_of_org ?? 0)
                  }}
                  @php($totalMoney += (@$report->get('تأهيل مهني')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('تأهيل مهني')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('تأهيل مهني')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('تأهيل مهني')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
           </tr>
 
           <tr>
              <td>تأهيل نسوي</td>
              <td>
                @if (!@is_null($report->get('تأهيل نسوي')) && !@is_null($report->get('تأهيل نسوي')['مطلوب']))
                  {{ $report->get('تأهيل نسوي')['مطلوب'][0]->count }}
                  @php($totalNeed += $report->get('تأهيل نسوي')['مطلوب'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (!@is_null($report->get('تأهيل نسوي')) && @isset($report->get('تأهيل نسوي')['منفذ']))
                  {{ @$report->get('تأهيل نسوي')['منفذ'][0]->count }}
                  @php($totalDone += $report->get('تأهيل نسوي')['منفذ'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (
                  !@is_null($report->get('تأهيل نسوي')) && !@is_null($report->get('تأهيل نسوي')['مطلوب']) && !@is_null($report->get('تأهيل نسوي')['منفذ'])
                  && $report->get('تأهيل نسوي')['منفذ'][0]->count > 0
                )
                  {{ round(($report->get('تأهيل نسوي')['منفذ'][0]->count  /  $report->get('تأهيل نسوي')['مطلوب'][0]->count) * 100, 1) . '%' }}
                @else
                  0%
                @endif
              </td>    
              <td>
                  {{ number_format((@$report->get('تأهيل نسوي')['منفذ'][0]->budget ?? 0) + (@$report->get('تأهيل نسوي')['مطلوب'][0]->budget ?? 0)) }}
                  @php($totalBudget += (@$report->get('تأهيل نسوي')['منفذ'][0]->budget ?? 0) + (@$report->get('تأهيل نسوي')['مطلوب'][0]->budget ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('تأهيل نسوي')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('تأهيل نسوي')['مطلوب'][0]->budget_from_org ?? 0)) }}
                  @php($totalBudgetFromOrg += (@$report->get('تأهيل نسوي')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('تأهيل نسوي')['مطلوب'][0]->budget_from_org ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('تأهيل نسوي')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('تأهيل نسوي')['مطلوب'][0]->budget_out_of_org ?? 0)) }}
                  @php($totalBudgetOutOfOrg += (@$report->get('تأهيل نسوي')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('تأهيل نسوي')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
              <td>
                  {{
                    (@$report->get('تأهيل نسوي')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('تأهيل نسوي')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('تأهيل نسوي')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('تأهيل نسوي')['مطلوب'][0]->budget_out_of_org ?? 0)
                  }}
                  @php($totalMoney += (@$report->get('تأهيل نسوي')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('تأهيل نسوي')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('تأهيل نسوي')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('تأهيل نسوي')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
           </tr>
            
           <tr>
              <td>تكريم متفوقين</td>
              <td>
                @if (!@is_null($report->get('تكريم متفوقين')) && !@is_null($report->get('تكريم متفوقين')['مطلوب']))
                  {{ $report->get('تكريم متفوقين')['مطلوب'][0]->count }}
                  @php($totalNeed += $report->get('تكريم متفوقين')['مطلوب'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (!@is_null($report->get('تكريم متفوقين')) && @isset($report->get('تكريم متفوقين')['منفذ']))
                  {{ @$report->get('تكريم متفوقين')['منفذ'][0]->count }}
                  @php($totalDone += @$report->get('تكريم متفوقين')['منفذ'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (
                  !@is_null($report->get('تكريم متفوقين')) && !@is_null($report->get('تكريم متفوقين')['مطلوب']) && !@is_null($report->get('تكريم متفوقين')['منفذ'])
                  && $report->get('تكريم متفوقين')['منفذ'][0]->count > 0
                )
                  {{ round(($report->get('تكريم متفوقين')['منفذ'][0]->count  /  $report->get('تكريم متفوقين')['مطلوب'][0]->count) * 100, 1) . '%' }}
                @else
                  0%
                @endif
              </td>    
              <td>
                  {{ number_format((@$report->get('تكريم متفوقين')['منفذ'][0]->budget ?? 0) + (@$report->get('تكريم متفوقين')['مطلوب'][0]->budget ?? 0)) }}
                  @php($totalBudget += (@$report->get('تكريم متفوقين')['منفذ'][0]->budget ?? 0) + (@$report->get('تكريم متفوقين')['مطلوب'][0]->budget ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('تكريم متفوقين')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('تكريم متفوقين')['مطلوب'][0]->budget_from_org ?? 0)) }}
                  @php($totalBudgetFromOrg += (@$report->get('تكريم متفوقين')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('تكريم متفوقين')['مطلوب'][0]->budget_from_org ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('تكريم متفوقين')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('تكريم متفوقين')['مطلوب'][0]->budget_out_of_org ?? 0)) }}
                  @php($totalBudgetOutOfOrg += (@$report->get('تكريم متفوقين')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('تكريم متفوقين')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
              <td>
                  {{ 
                    (@$report->get('تكريم متفوقين')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('تكريم متفوقين')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('تكريم متفوقين')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('تكريم متفوقين')['مطلوب'][0]->budget_out_of_org ?? 0)
                  }}
                  @php($totalMoney += (@$report->get('تكريم متفوقين')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('تكريم متفوقين')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('تكريم متفوقين')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('تكريم متفوقين')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
           </tr>
            
           <tr>
              <td>دراسات عليا</td>
              <td>
                @if (!@is_null($report->get('دراسات عليا')) && !@is_null($report->get('دراسات عليا')['مطلوب']))
                  {{ $report->get('دراسات عليا')['مطلوب'][0]->count }}
                  @php($totalNeed += $report->get('دراسات عليا')['مطلوب'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (!@is_null($report->get('دراسات عليا')) && @isset($report->get('دراسات عليا')['منفذ']))
                  {{ @$report->get('دراسات عليا')['منفذ'][0]->count }}
                  @php($totalDone += $report->get('دراسات عليا')['منفذ'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (
                  !@is_null($report->get('دراسات عليا')) && !@is_null($report->get('دراسات عليا')['مطلوب']) && !@is_null($report->get('دراسات عليا')['منفذ'])
                  && $report->get('دراسات عليا')['منفذ'][0]->count > 0
                )
                  {{ round(($report->get('دراسات عليا')['منفذ'][0]->count  /  $report->get('دراسات عليا')['مطلوب'][0]->count) * 100, 1) . '%' }}
                @else
                  0%
                @endif
              </td>    
              <td>
                  {{ number_format((@$report->get('دراسات عليا')['منفذ'][0]->budget ?? 0) + (@$report->get('دراسات عليا')['مطلوب'][0]->budget ?? 0)) }}
                  @php($totalBudget += (@$report->get('دراسات عليا')['منفذ'][0]->budget ?? 0) + (@$report->get('دراسات عليا')['مطلوب'][0]->budget ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('دراسات عليا')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('دراسات عليا')['مطلوب'][0]->budget_from_org ?? 0)) }}
                  @php($totalBudgetFromOrg += (@$report->get('دراسات عليا')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('دراسات عليا')['مطلوب'][0]->budget_from_org ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('دراسات عليا')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('دراسات عليا')['مطلوب'][0]->budget_out_of_org ?? 0)) }}
                  @php($totalBudgetOutOfOrg += (@$report->get('دراسات عليا')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('دراسات عليا')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
              <td>
                  {{ 
                    (@$report->get('دراسات عليا')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('دراسات عليا')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('دراسات عليا')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('دراسات عليا')['مطلوب'][0]->budget_out_of_org ?? 0)
                  }}
                  @php($totalMoney += (@$report->get('دراسات عليا')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('دراسات عليا')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('دراسات عليا')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('دراسات عليا')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
           </tr>
            
           <tr>
              <td>إعانات طلاب</td>
              <td>
                @if (!@is_null($report->get('إعانات طلاب')) && !@is_null($report->get('إعانات طلاب')['مطلوب']))
                  {{ $report->get('إعانات طلاب')['مطلوب'][0]->count }}
                   @php($totalNeed += $report->get('إعانات طلاب')['مطلوب'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (!@is_null($report->get('إعانات طلاب')) && @isset($report->get('إعانات طلاب')['منفذ']))
                  {{ @$report->get('إعانات طلاب')['منفذ'][0]->count }}
                  @php($totalDone += @$report->get('إعانات طلاب')['منفذ'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (
                  !@is_null($report->get('إعانات طلاب')) && !@is_null($report->get('إعانات طلاب')['مطلوب']) && !@is_null($report->get('إعانات طلاب')['منفذ'])
                  && $report->get('إعانات طلاب')['منفذ'][0]->count > 0
                )
                  {{ round(($report->get('إعانات طلاب')['منفذ'][0]->count  /  $report->get('إعانات طلاب')['مطلوب'][0]->count) * 100, 1) . '%' }}
                @else
                  0%
                @endif
              </td>    
              <td>
                {{ number_format((@$report->get('إعانات طلاب')['منفذ'][0]->budget ?? 0) + (@$report->get('إعانات طلاب')['مطلوب'][0]->budget ?? 0)) }}
                @php($totalBudget += (@$report->get('إعانات طلاب')['منفذ'][0]->budget ?? 0) + (@$report->get('إعانات طلاب')['مطلوب'][0]->budget ?? 0))
              </td>
              <td>
                {{ number_format((@$report->get('إعانات طلاب')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('إعانات طلاب')['مطلوب'][0]->budget_from_org ?? 0)) }}
                 @php($totalBudgetFromOrg += (@$report->get('إعانات طلاب')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('إعانات طلاب')['مطلوب'][0]->budget_from_org ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('إعانات طلاب')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('إعانات طلاب')['مطلوب'][0]->budget_out_of_org ?? 0)) }}
                   @php($totalBudgetOutOfOrg += (@$report->get('إعانات طلاب')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('إعانات طلاب')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
              <td>
                  {{ 
                    (@$report->get('إعانات طلاب')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('إعانات طلاب')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('إعانات طلاب')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('إعانات طلاب')['مطلوب'][0]->budget_out_of_org ?? 0)
                  }}
                   @php($totalMoney += (@$report->get('إعانات طلاب')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('إعانات طلاب')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('إعانات طلاب')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('إعانات طلاب')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
           </tr>

           <tr>
              <td>دورات رفع المستويات</td>
              <td>
                @if (!@is_null($report->get('دورات رفع المستويات')) && !@is_null($report->get('دورات رفع المستويات')['مطلوب']))
                  {{ $report->get('دورات رفع المستويات')['مطلوب'][0]->count }}
                   @php($totalNeed += $report->get('دورات رفع المستويات')['مطلوب'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (!@is_null($report->get('دورات رفع المستويات')) && @isset($report->get('دورات رفع المستويات')['منفذ']))
                  {{ @$report->get('دورات رفع المستويات')['منفذ'][0]->count }}
                  @php($totalDone += @$report->get('دورات رفع المستويات')['منفذ'][0]->count)
                @else
                  0
                @endif
              </td>
              <td>
                @if (
                  !@is_null($report->get('دورات رفع المستويات')) && !@is_null($report->get('دورات رفع المستويات')['مطلوب']) && !@is_null($report->get('دورات رفع المستويات')['منفذ'])
                  && $report->get('دورات رفع المستويات')['منفذ'][0]->count > 0
                )
                  {{ round(($report->get('دورات رفع المستويات')['منفذ'][0]->count  /  $report->get('دورات رفع المستويات')['مطلوب'][0]->count) * 100, 1) . '%' }}
                @else
                  0%
                @endif
              </td>    
              <td>
                {{ number_format((@$report->get('دورات رفع المستويات')['منفذ'][0]->budget ?? 0) + (@$report->get('دورات رفع المستويات')['مطلوب'][0]->budget ?? 0)) }}
                @php($totalBudget += (@$report->get('دورات رفع المستويات')['منفذ'][0]->budget ?? 0) + (@$report->get('دورات رفع المستويات')['مطلوب'][0]->budget ?? 0))
              </td>
              <td>
                {{ number_format((@$report->get('دورات رفع المستويات')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('دورات رفع المستويات')['مطلوب'][0]->budget_from_org ?? 0)) }}
                 @php($totalBudgetFromOrg += (@$report->get('دورات رفع المستويات')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('دورات رفع المستويات')['مطلوب'][0]->budget_from_org ?? 0))
              </td>
              <td>
                  {{ number_format((@$report->get('دورات رفع المستويات')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('دورات رفع المستويات')['مطلوب'][0]->budget_out_of_org ?? 0)) }}
                   @php($totalBudgetOutOfOrg += (@$report->get('دورات رفع المستويات')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('دورات رفع المستويات')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
              <td>
                  {{ 
                    (@$report->get('دورات رفع المستويات')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('دورات رفع المستويات')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('دورات رفع المستويات')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('دورات رفع المستويات')['مطلوب'][0]->budget_out_of_org ?? 0)
                  }}
                   @php($totalMoney += (@$report->get('دورات رفع المستويات')['منفذ'][0]->budget_from_org ?? 0) + (@$report->get('دورات رفع المستويات')['مطلوب'][0]->budget_from_org ?? 0)
                    + (@$report->get('دورات رفع المستويات')['منفذ'][0]->budget_out_of_org ?? 0) + (@$report->get('دورات رفع المستويات')['مطلوب'][0]->budget_out_of_org ?? 0))
              </td>
           </tr>
            
           <tr>
              <td>الإجمالي</td>
              <td>{{ $totalNeed }}</td>
              <td>{{ $totalDone }}</td>
              <td>{{ $totalDone > 0  ? round(($totalDone / $totalNeed) * 100, 1) : 0 }}%</td>
              <td>{{ number_format($totalBudget) }}</td>
              <td>{{ number_format($totalBudgetFromOrg) }}</td>
              <td>{{ number_format($totalBudgetOutOfOrg) }}</td>
              <td>{{ number_format($totalMoney) }}</td>
           </tr>


			    </x-slot:body>

          {{-- <caption>
            @empty(!request()->query('sector'))
              {{ request()->query('sector') . ' - ' . request()->query('locality')}}
            @else
            كل القطاعات
            @endempty
          </caption> --}}

		    </x-table>

      </div>
    </div>

  @include('components.footer')