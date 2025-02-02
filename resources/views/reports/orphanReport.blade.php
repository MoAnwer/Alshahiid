@include('components.header', ['page_title' => 'احصائية الأيتام'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>احصائية الأيتام</h4>
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
            <tr>
              <th>الفئة العمرية</th>
              <th colspan="2" class="border-left"> اقل من 5 سنوات</th> 
              <th colspan="2" class="border">  6 سنوات - 12 سنة</th> 
              <th colspan="2" class="border">  13 سنوات - 16 سنة</th> 
              <th colspan="2" class="border">  17 سنوات - 18 سنة</th> 
              <th colspan="4" class="border">المجموع</th> 
            </tr>
          </x-slot:head>
			
			    <x-slot:body>
            <tr>
              <td>اناث</td> 
              <td>ذكور</td> 

              <td>اناث</td> 
              <td>ذكور</td> 

              <td>اناث</td> 
              <td>ذكور</td> 

              <td>اناث</td> 
              <td>ذكور</td> 

              <td>اناث</td> 
              <td>ذكور</td> 
              <td>اناث</td> 
              <td>ارامل فقط</td> 
              <td>المجموع</td> 

            <tr>
              {{-- Ander 5 --}}
              <td>العدد</td>
              <td>{{ (@$report->get('ذكر')[0]->ander5 ?? 0) }}</td>
              <td>{{ (@$report->get('أنثى')[0]->ander5 ?? 0) }}</td>
              {{--/ Ander 5 --}}
              
              {{-- 6 - 12 --}}
              <td>{{ (@$report->get('ذكر')[0]->from6To12 ?? 0) }}</td>
              <td>{{ (@$report->get('أنثى')[0]->from6To12 ?? 0) }}</td>
              {{--/6 - 12  --}}

              {{-- 13 - 16 --}}
              <td>{{ (@$report->get('ذكر')[0]->from13To16 ?? 0) }}</td>
              <td>{{ (@$report->get('أنثى')[0]->from13To16 ?? 0) }}</td>
              {{--/ 13 - 16  --}}

              {{-- 17 - 18 --}}
              <td>{{ (@$report->get('ذكر')[0]->from17To18 ?? 0) }}</td>
              <td>{{ (@$report->get('أنثى')[0]->from17To18 ?? 0) }}</td>
              {{--/17 - 18  --}}
              
              {{-- Counts --}}
              <td>{{ (@$report->get('ذكر')[0]->countOfMales ?? 0) }}</td>
              <td>{{ (@$report->get('أنثى')[0]->countOfFemales ?? 0) }}</td>
              {{--/ Counts --}}

              <td>{{ $countOfWidow }}</td>
              <td>{{ $totalCountOfMembers }}</td>

            </tr>

            <tr>
              
              {{-- Ander 5 --}}
              <td>النسبة</td>

                @if (@$totalCountOfMembers > 0 && @$report->get('ذكر')[0]->ander5 > 0)
                <td>{{ round((@$report->get('ذكر')[0]->ander5 / @$totalCountOfMembers) * 100, 2) . '%' }}</td>
                @else
                  <td>0%</td>
                @endif
                @if (@$totalCountOfMembers > 0 && @$report->get('أنثى')[0]->ander5 > 0)
                <td>{{ round((@$report->get('أنثى')[0]->ander5 / @$totalCountOfMembers) * 100, 2) . '%' }}</td>
                @else
                  <td>0%</td>
                @endif
              {{--/ Ander 5 --}}

              {{-- 6 - 12 --}}
                @if (@$totalCountOfMembers > 0 && @$report->get('ذكر')[0]->from6To12 > 0)
                <td>{{ round((@$report->get('ذكر')[0]->from6To12 / @$totalCountOfMembers) * 100, 2) . '%' }}</td>
                @else
                  <td>0%</td>
                @endif
                @if (@$totalCountOfMembers > 0 && @$report->get('أنثى')[0]->from6To12 > 0)
                <td>{{ round((@$report->get('أنثى')[0]->from6To12 / @$totalCountOfMembers) * 100, 2) . '%' }}</td>
                @else
                  <td>0%</td>
                @endif
              {{--/ 6 - 12 --}}

              {{-- 13 -16 --}}
                @if (@$totalCountOfMembers > 0 && @$report->get('ذكر')[0]->from13To16 > 0)
                <td>{{ round((@$report->get('ذكر')[0]->from13To16 / @$totalCountOfMembers) * 100, 2) . '%' }}</td>
                @else
                  <td>0%</td>
                @endif
                @if (@$totalCountOfMembers > 0 && @$report->get('أنثى')[0]->from13To16 > 0)
                <td>{{ round((@$report->get('أنثى')[0]->from13To16 / @$totalCountOfMembers) * 100, 2) . '%' }}</td>
                @else
                  <td>0%</td>
                @endif
              {{--/ 13 -16 --}}

              {{-- 17 - 18 --}}
                @if (@$totalCountOfMembers > 0 && @$report->get('ذكر')[0]->from17To18 > 0)
                <td>{{ round((@$report->get('ذكر')[0]->from17To18 / @$totalCountOfMembers) * 100, 2) . '%' }}</td>
                @else
                  <td>0%</td>
                @endif
                @if (@$totalCountOfMembers > 0 && @$report->get('أنثى')[0]->from17To18 > 0)
                <td>{{ round((@$report->get('أنثى')[0]->from17To18 / @$totalCountOfMembers) * 100, 2) . '%' }}</td>
                @else
                  <td>0%</td>
                @endif
              {{--/ 17 - 18 --}}

              {{-- COUNT --}}
                @if ($totalCountOfMembers > 0 && @$report->get('ذكر')[0]->countOfMales > 0)
                  <td>{{ round((@$report->get('ذكر')[0]->countOfMales / $totalCountOfMembers) * 100, 2) }}%</td>
                  @else
                    <td>0%</td>
                @endif

                @if ($totalCountOfMembers > 0 && @$report->get('أنثى')[0]->countOfFemales > 0)
                <td>{{ round((@$report->get('أنثى')[0]->countOfFemales / $totalCountOfMembers) * 100, 2) }}%</td>
                @else
                  <td>0%</td>
                @endif

                @if ($totalCountOfMembers > 0 && @$countOfWidow > 0)
                <td>{{ round((@$countOfWidow / $totalCountOfMembers) * 100, 2) }}%</td>
                @else
                  <td>0%</td>
                @endif

                @if ($totalCountOfMembers > 0)
                <td>100%</td>
                @else
                  <td>0%</td>
                @endif

              {{--/ COUNT --}}

            </tr>


            </tr>
            <caption>
              @empty(!request()->query('sector'))
                {{ request()->query('sector') . ' - ' . request()->query('locality')}}
              @else
              كل القطاعات
              @endempty
            </caption>
			    </x-slot:body>
		    </x-table>

      </div>
    </div>

  @include('components.footer')