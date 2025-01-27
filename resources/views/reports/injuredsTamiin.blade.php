@include('components.header', ['page_title' => 'التأمين الصحي بالمعاقين'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <h4>التأمين الصحي بالمعاقين</h4>
        <x-table>
           <x-slot:head>
              <th>نسبة العجز</th>
              <th>العدد المؤمن</th>
              <th>غير مؤمن</th>
              <th>المجموع</th>
            </x-slot:head>
      
           <x-slot:body>
            <tr>
              <td>العدد</td>
              <td>{{ $report['has'] }}</td>
              <td>{{ $report['no'] }}</td>
              <td>{{ $report['total'] }}</td>
            </tr>
            <tr>
              <td>النسبة</td>
              <td>
                @if($report['has'] > 0)
                  {{ round(($report['has'] / $report['total']) * 100, 1) . '%'}}
                @else
                  0
                @endif
              </td>
              <td>
                @if($report['no'] > 0)
                  {{ round(($report['no'] / $report['total']) * 100, 1) . '%'}}
                @else
                  0
                @endif
              </td>
              <td>100%</td>
            </tr>

           </x-slot:body>

         </x-table>
      </div>

      </div>
    </div>

  @include('components.footer')