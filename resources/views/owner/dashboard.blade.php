<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PHV-Dashboard</title>
    <link rel="icon" type="image/png" href="/images/logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/ownerdashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="navbar-logo">
            <img src="{{ asset('images/logo.png') }}" alt="PetHealthVault Logo" class="logo-img">
            <h1 class="logo-text">Pet Health Vault</h1>
        </div>
        <div class="profile-notification-wrap">
            <div class="profile-dropdown">
                <div onclick="toggle()" class="profile-dropdown-btn">
                    <span>{{ Auth::user()->firstname }}</span>
                    <span><i class="fa-solid fa-angle-down"></i></span>
                </div>
                <ul class="profile-dropdown-list">
                    <li class="profile-dropdown-list-item">
                        <form action="{{ route('change.password') }}" method="GET">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer;">
                                <i class="fa-regular fa-user"></i> Change Password
                            </button>
                        </form>
                    </li>
                    <li class="profile-dropdown-list-item">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer;">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-content-container">
        <aside>
            <div class="profile">
                <h2><i class="fas fa-user"></i> My Profile</h2>
                <p>Name: <a href="#">{{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}</a></p>
                <p>Address: <a href="#">Brgy. {{ Auth::user()->address }}</a></p>
                <p>Phone: <a href="#">{{ Auth::user()->phone_number }}</a></p>
                <p>Email: <a href="#">{{ Auth::user()->email }}</a></p>
            </div>
        </aside>

        <div class="wrapper">
            <h2 class="welcome">Welcome, <i>{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}!</i></h2>
            <p class="subtext">Review up-to-date health records and visit summaries.</p>
            <div class="tabs-container">
                <!-- PET TABS -->
                <ul class="pet-tabs" role="tablist">
                    @foreach($pets as $pet)
                    <li>
                        <a href="#pet-{{ $pet->PetID }}" class="{{ $loop->first ? 'active' : '' }}" onclick="showPetTab('{{ $pet->PetID }}')">
                            {{ $pet->Name }}
                        </a>
                    </li>
                    @endforeach
                </ul>

                <div class="tabs__panels">
                    @foreach($pets as $pet)
                    <div id="pet-{{ $pet->PetID }}" class="tab-pane" style="display: none;">
                        <!-- NESTED TABS (PET PROFILE, HEALTH RECORDS, APPOINTMENTS) -->
                        <ul class="nested-tabs">
                            <li><a href="#profile-{{ $pet->PetID }}" class="nested-tab-link active" onclick="showSubTab('{{ $pet->PetID }}', 'profile')">Pet Profile</a></li>
                            <li><a href="#health-{{ $pet->PetID }}" class="nested-tab-link" onclick="showSubTab('{{ $pet->PetID }}', 'health')">Health Records</a></li>
                            <li><a href="#appointments-{{ $pet->PetID }}" class="nested-tab-link" onclick="showSubTab('{{ $pet->PetID }}', 'appointments')">Appointments</a></li>
                        </ul>

                        <!-- PET PROFILE TAB -->
                        <div id="profile-{{ $pet->PetID }}" class="nested-tab-pane">
                            <div class="dashboard-section">
                                <div class="pet-profile">
                                    @if($pet->Image)
                                    <img src="{{ asset('storage/' . $pet->Image) }}" alt="{{ $pet->Name }}" class="pet-profile-image">
                                    @else
                                    <div class="no-image-placeholder">
                                        <i class="fas fa-paw"></i>
                                    </div>
                                    @endif

                                    <div class="pet-info">
                                        <div class="pet-details">
                                            <p><strong>Name:</strong> {{ $pet->Name }} </p>
                                            <p><strong>Species:</strong> {{ $pet->Species }} </p>
                                            <p><strong>Breed:</strong> {{ $pet->Breed }} </p>
                                            <p><strong>Age:</strong> {{ $pet->AgeYears }} year/s & {{ $pet->AgeMonths }} month/s</p>
                                            <p><strong>Gender:</strong> {{ $pet->Gender }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- HEALTH RECORD TAB -->
                        <div id="health-{{ $pet->PetID }}" class="nested-tab-pane" style="display:none">
                            <!-- VACCINATION -->
                            <div class="dashboard-section">
                                <div class="header-row">
                                    <h3><i class="fas fa-stethoscope"></i> Diagnosis </h3>
                                    <select id="diagnosis-record-date-{{ $pet->PetID }}" class="record-date-dropdown" onchange="changeRecordDate('diagnosis', '{{ $pet->PetID }}', this)">
                                        @php
                                        $sortedDiagnosis = $pet->diagnosis->sortByDesc(function($d) {
                                        return \Carbon\Carbon::parse($d->RecordDate);
                                        });
                                        @endphp

                                        @forelse($sortedDiagnosis as $diagnosis)
                                        <option value="{{ \Carbon\Carbon::parse($diagnosis->RecordDate)->format('Y-m-d') }}"
                                            {{ $loop->first ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::parse($diagnosis->RecordDate)->format('M d, Y') }}
                                        </option>
                                        @empty
                                        <option value="">No records available</option>
                                        @endforelse
                                    </select>
                                </div>
                                @if($pet->diagnosis->isNotEmpty())
                                <div class="table-wrapper">
                                    <table class="health-table" id="diagnosis-table-{{ $pet->PetID }}">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Diagnosis</th>
                                                <th>Vet</th>
                                            </tr>
                                        </thead>
                                        @foreach($sortedDiagnosis as $diagnosis)
                                        <tbody id="diagnosis-body-{{ $pet->PetID }}-{{ \Carbon\Carbon::parse($diagnosis->RecordDate)->format('Y-m-d') }}" @if(!$loop->first) style="display:none" @endif>

                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($diagnosis->RecordDate)->format('M d, Y') }}</td>
                                                <td>{{ $diagnosis->Diagnosis }}</td>
                                                <td>{{ $diagnosis->Veterinarian }}</td>
                                            </tr>
                                        </tbody>
                                        @endforeach
                                    </table>
                                </div>
                                @else
                                <p class="no-records">No diagnosis & medication records found.</p>
                                @endif

                            </div>

                            <!-- MEDICATION -->
                            <div class="dashboard-section">
                                <h3><i class="fas fa-pills"></i> Medication</h3>
                                @foreach($pet->diagnosis as $diagnosis)
                                @if($diagnosis->medication)
                                <div class="table-wrapper">
                                    <table class="health-table" id="medication-table-{{ $pet->PetID }}-{{ \Carbon\Carbon::parse($diagnosis->RecordDate)->format('Y-m-d') }}" @if(!$loop->first) style="display:none" @endif>
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Dosage</th>
                                                <th>Frequency</th>
                                                <th>Duration</th>
                                                <th>Type</th>
                                                <th>Stock Quantity</th>
                                                <th>Expiration Date</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $diagnosis->medication->ProductName }}</td>
                                                <td>{{ $diagnosis->medication->Dosage }}</td>
                                                <td>{{ $diagnosis->medication->Frequency }}</td>
                                                <td>{{ $diagnosis->medication->DurationDays ?? 'N/A' }}</td>
                                                <td>{{ $diagnosis->medication->Type ?? 'N/A' }}</td>
                                                <td>{{ $diagnosis->medication->StockQuantity }}</td>
                                                <td>{{ $diagnosis->medication->ExpirationDate ? \Carbon\Carbon::parse($diagnosis->medication->ExpirationDate)->format('M d, Y') : 'N/A' }}</td>
                                                <td>{{ $diagnosis->medication->Price ? '₱' . number_format($diagnosis->medication->Price, 2) : 'N/A' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                                @endforeach
                            </div>

                            <!-- VACCINATION -->
                            <div class="dashboard-section">
                                @php
                                $groupedVaccinations = $pet->vaccination->groupBy(function ($item) {
                                return \Carbon\Carbon::parse($item->RecordDate)->format('Y-m-d');
                                });

                                // Sort keys descending (latest date first)
                                $groupedVaccinations = $groupedVaccinations->sortKeysDesc();
                                @endphp

                                <div class="header-row">
                                    <h3><i class="fas fa-syringe"></i> Vaccination </h3>
                                    <select id="vaccination-record-date-{{ $pet->PetID }}" class="record-date-dropdown" onchange="changeRecordDate('vaccination', '{{ $pet->PetID }}', this)">
                                        @forelse ($groupedVaccinations as $date => $records)
                                        <option value="{{ $date }}" {{ $loop->first ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::parse($date)->format('M d, Y') }}
                                        </option>
                                        @empty
                                        <option value="">No records available</option>
                                        @endforelse
                                    </select>
                                </div>


                                @if ($groupedVaccinations->isNotEmpty())
                                @foreach ($groupedVaccinations as $date => $records)
                                <div class="table-wrapper" id="vaccination-body-{{ $pet->PetID }}-{{ $date }}" @if (!$loop->first) style="display: none;" @endif>
                                    <table class="health-table">
                                        <thead>
                                            <tr>
                                                <th>Vaccine</th>
                                                <th>Date</th>
                                                <th>Next Due</th>
                                                <th>Vet</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($records as $vaccination)
                                            <tr>
                                                <td>{{ $vaccination->VaccinationName }}</td>
                                                <td>{{ \Carbon\Carbon::parse($vaccination->RecordDate)->format('M d, Y') }}</td>
                                                <td>{{ $vaccination->NextDueDate ? \Carbon\Carbon::parse($vaccination->NextDueDate)->format('M d, Y') : 'N/A' }}</td>
                                                <td>{{ $vaccination->Veterinarian }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endforeach
                                @else
                                <p class="no-records">No vaccination records found.</p>
                                @endif
                            </div>
                        </div>

                        <!-- APPOINTMENT TAB -->
                        <div id="appointments-{{ $pet->PetID }}" class="nested-tab-pane" style="display:none">
                            <div class="dashboard-section">
                                @if (session('success'))
                                <div class="message" style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
                                    {{ session('success') }}
                                </div>
                                @endif

                                <div class="header-row">
                                    <h3><i class="fas fa-calendar-check"></i> Appointments </h3>
                                    <button id="schedule-appointment-btn-{{ $pet->PetID }}" class="schedule-appointment-btn" onclick="toggleScheduleForm('{{ $pet->PetID }}')">Schedule Appointment</button>
                                </div>

                                <div id="appointment-table-container-{{ $pet->PetID }}">
                                    @php
                                    $appointments = $pet->appointment ?? collect(); // Make sure it's a collection
                                    $latestAppointment = $appointments->sortByDesc('AppointmentDate')->first();

                                    $showAppointment = false;

                                    if ($latestAppointment) {
                                    $status = strtolower($latestAppointment->Status);
                                    $allowedStatuses = ['pending', 'approved', 'completed'];

                                    if (in_array($status, $allowedStatuses)) {
                                    if ($status === 'completed') {
                                    $appointmentDate = \Carbon\Carbon::parse($latestAppointment->AppointmentDate);
                                    $today = \Carbon\Carbon::today();
                                    if ($appointmentDate->diffInDays($today) <= 7) {
                                        $showAppointment=true;
                                        }
                                        } else {
                                        $showAppointment=true;
                                        }
                                        }
                                        }
                                        @endphp

                                        @if($showAppointment)
                                        <div class="table-wrapper">
                                        <table class="health-table" id="appointment-table-{{ $pet->PetID }}">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($latestAppointment->AppointmentDate)->format('M d, Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($latestAppointment->AppointmentTime)->format('h:i A') }}</td>
                                                    <td>{{ $latestAppointment->Description ?? 'None' }}</td>
                                                    <td>{{ $latestAppointment->Status }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                </div>
                                @else
                                <p class="no-records">No appointment records found.</p>
                                @endif



                            </div>


                            <!-- Schedule Appointment Form -->
                            <div id="schedule-appointment-form-{{ $pet->PetID }}" class="schedule-appointment-form" style="display:none;">
                                <div class="container">
                                    <div class="title">Schedule Appointment</div>
                                    <div class="content">
                                        <form action="{{ route('appointment.store') }}" method="POST">
                                            @csrf

                                            <div class="user-details">
                                                <div class="input-box">
                                                    <span class="details">Pet</span>
                                                    <select name="PetID" required>
                                                        @foreach ($pets as $pet)
                                                        <option value="{{ $pet->PetID }}">{{ $pet->Name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="input-box">
                                                    <span class="details">First Name</span>
                                                    <input type="text" name="FirstName" placeholder="Enter your first name" required>
                                                </div>

                                                <div class="input-box">
                                                    <span class="details">Last Name</span>
                                                    <input name="LastName" type="text" placeholder="Enter your last name" required>
                                                </div>

                                                <div class="input-box">
                                                    <span class="details">Email</span>
                                                    <input name="OwnerEmail" type="email" placeholder="Enter your email" required>
                                                </div>

                                                {{-- Date Dropdown --}}
                                                <div class="input-box">
                                                    <span class="details">Appointment Date</span>
                                                    <select name="AppointmentDate" required>
                                                        @php
                                                        $today = \Carbon\Carbon::today();
                                                        $dates = [];

                                                        // Generate next 14 valid days (Mon–Sat)
                                                        for ($i = 0; count($dates) < 14 && $i < 30; $i++) {
                                                            $day=$today->copy()->addDays($i);
                                                            if (!$day->isSunday()) {
                                                            $dates[] = $day;
                                                            }
                                                            }
                                                            @endphp

                                                            @foreach ($dates as $date)
                                                            <option value="{{ $date->format('Y-m-d') }}">
                                                                {{ $date->format('l, F j, Y') }}
                                                            </option>
                                                            @endforeach
                                                    </select>
                                                </div>

                                                {{-- Time Dropdown --}}
                                                <div class="input-box">
                                                    <span class="details">Appointment Time</span>
                                                    <select name="AppointmentTime" required>
                                                        @php
                                                        $hours = [];
                                                        foreach (range(9, 12) as $h) $hours[] = "$h:00";
                                                        foreach (range(13, 18) as $h) $hours[] = "$h:00";
                                                        @endphp
                                                        @foreach ($hours as $hour)
                                                        <option value="{{ $hour }}">{{ \Carbon\Carbon::parse($hour)->format('g A') }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                {{-- Reason Dropdown --}}
                                                <div class="input-box">
                                                    <span class="details">Reason for Visit</span>
                                                    <select name="Description" required>
                                                        <option value="">Select a reason</option>
                                                        <option value="Vaccination">Vaccination</option>
                                                        <option value="Check-up">Check-up</option>
                                                        <option value="Grooming">Grooming</option>
                                                        <option value="Illness">Illness</option>
                                                        <option value="Follow-up">Follow-up</option>
                                                        <option value="Surgery Consultation">Surgery Consultation</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="button">
                                                <button type="submit">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>

    <footer class="footer">
        <p>@2024-2025 Pet Health Vault. All rights reserved.</p>
    </footer>
    <script src="{{ asset('js/ownerdashboard.js') }}"></script>
</body>

</html>