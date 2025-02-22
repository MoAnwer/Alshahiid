@include('components.header', ['page_title' => "الشهداء الذين قدمتهم اسرة الشهيد $family->martyr->name "])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">

        <div class="d-flex justify-content-between align-items-center px-3">
            <div>
              <h3>الشهداء الذين قدمتهم اسرة الشهيد {{ $family->martyr->name }} </h3>
            </div>
            <div class="d-flex align-items-end mt-5 align-items-end">
              <button class="mx-4 btn  btn-primary active" onclick="printTable()">
              <i class="bi bi-printer ml-2"></i>
                طباعة 
              </button>
            </div>
        </div>

        <hr />

        <x-table>
            <x-slot:head>
                <th>اسم الشهيد</th>
                <th>القوة</th>
                <th>الوحدة</th>
                <th>الرتبة</th>
                <th>النمرة العسكرية</th>
                <th>تاريخ الإستشهاد</th>
                <th>مكان الإستشهاد</th>
                <th>رقم السجل</th>
                <th>تاريخ السجل</th>
                <th>الشريحة</th>
                <th>الحقوق</th>
                <th>القطاع</th>
                <th>المحلية</th>
            </x-slot:head>

            <x-slot:body>
            @forelse ($martyrs as $martyr)
              <tr>
                  <td>{{ $martyr->name }}</td>
                  <td>{{ $martyr->force }}</td>
                  <td>{{ $martyr->unit }}</td>
                  <td>{{ $martyr->rank }}</td>
                  <td>{{ $martyr->militarism_number }}</td>
                  <td>{{ $martyr->martyrdom_date }}</td>
                  <td>{{ $martyr->martyrdom_place }}</td>
                  <td>{{ $martyr->record_number }}</td>
                  <td>{{ $martyr->record_date }}</td>
                  <td>{{ $family->category ?? '-' }}</td>
                  <td>{{ number_format($martyr->rights) }}</td>
                  <td>{{ $family->address->sector ?? '-' }}</td>
                  <td>{{ $family->address->locality ?? '-' }}</td>
                </tr>
              @empty
                <tr><td colspan="12"> لا توجد نتائج </td></tr>
              @endforelse

              <caption>
                  الشهداء الذين قدمتهم اسرة الشهيد {{ $family->martyr->name }}
              </captio>
              </x-slot:body>

          </x-table>
        </div>

    </div>

  @include('components.footer')