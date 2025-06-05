@extends('layouts.admin')



@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-3">
            <div class="card h-100" style="background: linear-gradient(135deg, #28a745, #20c997); color: white; border: none; border-radius: 10px;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0 fw-bold">24</h2>
                        <p class="mb-1">CHAMBRES OCCUPÉES</p>
                        <small><i class="bi bi-arrow-up"></i> 12% plus élevé</small>
                    </div>
                    <div>
                        <i class="bi bi-door-open" style="font-size: 3rem; opacity: 0.8;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-3">
            <div class="card h-100" style="background: linear-gradient(135deg, #17a2b8, #007bff); color: white; border: none; border-radius: 10px;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0 fw-bold">42</h2>
                        <p class="mb-1">NOUVELLES RÉSERVATIONS</p>
                        <small><i class="bi bi-arrow-up"></i> 18% plus élevé</small>
                    </div>
                    <div>
                        <i class="bi bi-calendar-check" style="font-size: 3rem; opacity: 0.8;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-3">
            <div class="card h-100" style="background: linear-gradient(135deg, #fd7e14, #ffc107); color: white; border: none; border-radius: 10px;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0 fw-bold">€15,890</h2>
                        <p class="mb-1">REVENUS JOURNALIERS</p>
                        <small><i class="bi bi-arrow-up"></i> 8% plus élevé</small>
                    </div>
                    <div>
                        <i class="bi bi-currency-euro" style="font-size: 3rem; opacity: 0.8;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-3">
            <div class="card h-100" style="background: linear-gradient(135deg, #dc3545, #e83e8c); color: white; border: none; border-radius: 10px;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0 fw-bold">85%</h2>
                        <p class="mb-1">TAUX D'OCCUPATION</p>
                        <small><i class="bi bi-arrow-up"></i> 5% plus élevé</small>
                    </div>
                    <div>
                        <i class="bi bi-building" style="font-size: 3rem; opacity: 0.8;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <!-- Main Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm" style="border-radius: 10px; border: none;">
                <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #f1f3f4;">
                    <div>
                        <h5 class="mb-0">Statistiques</h5>
                        <small class="text-muted">Analyse des performances de votre hôtel</small>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <h6 class="text-muted mb-0 me-2">REVENUS HEBDOMADAIRES</h6>
                            </div>
                            <h4 class="mb-0">€98,450 <small class="text-success"><i class="bi bi-arrow-up"></i> +12%</small></h4>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <h6 class="text-muted mb-0 me-2">RÉSERVATIONS HEBDO</h6>
                            </div>
                            <h4 class="mb-0">287 <small class="text-warning"><i class="bi bi-arrow-up"></i> +15%</small></h4>
                        </div>
                    </div>
                    <div style="height: 300px; background: #f8f9fa; border-radius: 8px; position: relative;">
                        <canvas id="salesChart" style="width: 100%; height: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Sidebar -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100" style="border-radius: 10px; border: none;">
                <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #f1f3f4;">
                    <h5 class="mb-0">Types de Chambres</h5>
                </div>
                <div class="card-body">
                    <!-- Donut Chart -->
                    <div class="text-center mb-4">
                        <canvas id="donutChart" style="width: 200px; height: 200px; margin: 0 auto;"></canvas>
                    </div>
                    
                    <!-- Room Type Stats -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle me-2" style="width: 12px; height: 12px; background-color: #28a745;"></div>
                                <span>Standard 42%</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle me-2" style="width: 12px; height: 12px; background-color: #17a2b8;"></div>
                                <span>Deluxe 35%</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle me-2" style="width: 12px; height: 12px; background-color: #ffc107;"></div>
                                <span>Suite 23%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Service Stats -->
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Restaurant</span>
                            <span class="text-success">↗ 32%</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Spa & Wellness</span>
                            <span class="text-success">↗ 28%</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Room Service</span>
                            <span class="text-warning">↗ 15%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="row">
        <!-- Guest Origin Map -->
        <div class="col-lg-5 mb-4"> 
            <div class="card shadow-sm" style="border-radius: 10px; border: none;">
                <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #f1f3f4;">
                    <h5 class="mb-0">Origine des Clients</h5>
                    <div>
                        <button class="btn btn-sm btn-outline-secondary me-1">+</button>
                        <button class="btn btn-sm btn-outline-secondary">-</button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- World Map Placeholder -->
                    <div style="height: 200px; background: #f8f9fa; border-radius: 8px; position: relative; margin-bottom: 20px;">
                        <div class="d-flex align-items-center justify-content-center h-100">
                        <img src="{{ asset('images/map_marroc.jpg') }}" alt="Carte du Maroc" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <!-- Simulated map points -->
                        <div style="position: absolute; top: 30%; left: 20%; width: 8px; height: 8px; background: #007bff; border-radius: 50%;"></div>
                        <div style="position: absolute; top: 45%; left: 55%; width: 8px; height: 8px; background: #007bff; border-radius: 50%;"></div>
                        <div style="position: absolute; top: 60%; left: 75%; width: 8px; height: 8px; background: #007bff; border-radius: 50%;"></div>
                        <div style="position: absolute; top: 25%; left: 45%; width: 8px; height: 8px; background: #007bff; border-radius: 50%;"></div>
                    </div>

                    <!-- City Stats -->
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr style="border: none;">
                                    <th style="border: none; color: #6c757d; font-weight: 600;">Ville</th>
                                    <th style="border: none; color: #6c757d; font-weight: 600;">Clients</th>
                                    <th style="border: none; color: #6c757d; font-weight: 600;">Taux</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border: none;">Paris</td>
                                    <td style="border: none;">125</td>
                                    <td style="border: none;">
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-success" style="width: 85%"></div>
                                        </div>
                                        <small>85%</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: none;">Madrid</td>
                                    <td style="border: none;">98</td>
                                    <td style="border: none;">
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-warning" style="width: 72%"></div>
                                        </div>
                                        <small>72%</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: none;">Londres</td>
                                    <td style="border: none;">87</td>
                                    <td style="border: none;">
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-danger" style="width: 68%"></div>
                                        </div>
                                        <small>68%</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: none;">Berlin</td>
                                    <td style="border: none;">65</td>
                                    <td style="border: none;">
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-info" style="width: 54%"></div>
                                        </div>
                                        <small>54%</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: none;">Rome</td>
                                    <td style="border: none;">52</td>
                                    <td style="border: none;">
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-info" style="width: 45%"></div>
                                        </div>
                                        <small>45%</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks and Messages -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm mb-4" style="border-radius: 10px; border: none;">
                <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #f1f3f4;">
                    <h5 class="mb-0">Tâches</h5>
                    <button class="btn btn-sm btn-primary">Nouvelle Tâche</button>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 py-3">
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle bg-light me-3 mt-1" style="width: 8px; height: 8px;"></div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Inspection chambre 205</h6>
                                    <small class="text-muted">15 Juin 2025</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0 py-3">
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle bg-success me-3 mt-1" style="width: 8px; height: 8px;"></div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><del>Maintenance climatisation</del></h6>
                                    <small class="text-muted">28 Mai 2025</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0 py-3">
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle bg-danger me-3 mt-1" style="width: 8px; height: 8px;"></div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Rapport mensuel</h6>
                                    <small class="text-muted">Pas de date limite</small>
                                    <span class="badge bg-danger ms-2">3 hrs</span>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0 py-3">
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle bg-success me-3 mt-1" style="width: 8px; height: 8px;"></div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><del>Formation personnel</del></h6>
                                    <small class="text-muted">10 Avril 2025</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0 py-3">
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle bg-light me-3 mt-1" style="width: 8px; height: 8px;"></div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Rénovation lobby</h6>
                                    <small class="text-muted">12 Dec 2025</small>
                                    <span class="badge bg-success ms-2">6 Mois</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Messages -->
            <div class="card shadow-sm" style="border-radius: 10px; border: none;">
                <div class="card-header bg-white" style="border-bottom: 1px solid #f1f3f4;">
                    <h5 class="mb-0">Messages</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 py-3">
                            <div class="d-flex align-items-start">
                                <img src="https://ui-avatars.com/api/?name=Marie+Dubois&background=007bff&color=fff&size=40" class="rounded-circle me-3" width="40" height="40">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1">Marie Dubois</h6>
                                        <small class="text-muted">14:30</small>
                                    </div>
                                    <p class="mb-0 text-muted small">Merci pour l'excellent service durant notre séjour...</p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0 py-3">
                            <div class="d-flex align-items-start">
                                <img src="https://ui-avatars.com/api/?name=Carlos+Rodriguez&background=28a745&color=fff&size=40" class="rounded-circle me-3" width="40" height="40">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1">Carlos Rodriguez</h6>
                                        <small class="text-muted">Il y a 2h</small>
                                    </div>
                                    <p class="mb-0 text-muted small">Est-il possible de réserver une table au restaurant pour ce soir...</p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0 py-3">
                            <div class="d-flex align-items-start">
                                <img src="https://ui-avatars.com/api/?name=John+Smith&background=dc3545&color=fff&size=40" class="rounded-circle me-3" width="40" height="40">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1">John Smith</h6>
                                        <small class="text-muted">Il y a 4h</small>
                                    </div>
                                    <p class="mb-0 text-muted small">J'aimerais prolonger mon séjour d'une nuit supplémentaire...</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Bookings and Popular Services -->
        <div class="col-lg-4">
            <!-- Latest Bookings -->
            <div class="card shadow-sm mb-4" style="border-radius: 10px; border: none;">
                <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #f1f3f4;">
                    <h5 class="mb-0">Dernières Réservations</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Actions
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Voir tout</a></li>
                            <li><a class="dropdown-item" href="#">Exporter</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="border: none; color: #6c757d; font-weight: 600; padding: 12px;">Réf</th>
                                    <th style="border: none; color: #6c757d; font-weight: 600; padding: 12px;">Client</th>
                                    <th style="border: none; color: #6c757d; font-weight: 600; padding: 12px;">Montant</th>
                                    <th style="border: none; color: #6c757d; font-weight: 600; padding: 12px;">Statut</th>
                                    <th style="border: none; color: #6c757d; font-weight: 600; padding: 12px;">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border: none; padding: 12px;"><a href="#" class="text-primary">HTL2584</a></td>
                                    <td style="border: none; padding: 12px;">@marie</td>
                                    <td style="border: none; padding: 12px;">€320.00</td>
                                    <td style="border: none; padding: 12px;"><span class="badge bg-success">Confirmé</span></td>
                                    <td style="border: none; padding: 12px;">15/06/2025</td>
                                </tr>
                                <tr>
                                    <td style="border: none; padding: 12px;"><a href="#" class="text-primary">HTL2575</a></td>
                                    <td style="border: none; padding: 12px;">@carlos</td>
                                    <td style="border: none; padding: 12px;">€180.00</td>
                                    <td style="border: none; padding: 12px;"><span class="badge bg-success">Confirmé</span></td>
                                    <td style="border: none; padding: 12px;">14/06/2025</td>
                                </tr>
                                <tr>
                                    <td style="border: none; padding: 12px;"><a href="#" class="text-primary">HTL1204</a></td>
                                    <td style="border: none; padding: 12px;">@john</td>
                                    <td style="border: none; padding: 12px;">€450.00</td>
                                    <td style="border: none; padding: 12px;"><span class="badge bg-secondary">En attente</span></td>
                                    <td style="border: none; padding: 12px;">13/06/2025</td>
                                </tr>
                                <tr>
                                    <td style="border: none; padding: 12px;"><a href="#" class="text-primary">HTL7578</a></td>
                                    <td style="border: none; padding: 12px;">@anna</td>
                                    <td style="border: none; padding: 12px;">€275.00</td>
                                    <td style="border: none; padding: 12px;"><span class="badge bg-warning">Expiré</span></td>
                                    <td style="border: none; padding: 12px;">12/06/2025</td>
                                </tr>
                                <tr>
                                    <td style="border: none; padding: 12px;"><a href="#" class="text-primary">HTL0158</a></td>
                                    <td style="border: none; padding: 12px;">@thomas</td>
                                    <td style="border: none; padding: 12px;">€680.00</td>
                                    <td style="border: none; padding: 12px;"><span class="badge bg-secondary">En attente</span></td>
                                    <td style="border: none; padding: 12px;">11/06/2025</td>
                                </tr>
                                <tr>
                                    <td style="border: none; padding: 12px;"><a href="#" class="text-primary">HTL0127</a></td>
                                    <td style="border: none; padding: 12px;">@sophie</td>
                                    <td style="border: none; padding: 12px;">€195.00</td>
                                    <td style="border: none; padding: 12px;"><span class="badge bg-success">Confirmé</span></td>
                                    <td style="border: none; padding: 12px;">10/06/2025</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Popular Services -->
            <div class="card shadow-sm" style="border-radius: 10px; border: none;">
                <div class="card-header bg-white" style="border-bottom: 1px solid #f1f3f4;">
                    <h5 class="mb-0">Services Populaires</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3 p-2" style="background-color: #f8f9fa; border-radius: 8px;">
                        <div class="bg-primary rounded p-2 me-3">
                            <i class="bi bi-cup-hot text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Restaurant</h6>
                            <small class="text-muted">Service de restauration</small>
                        </div>
                        <div>
                            <strong>148</strong>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3 p-2" style="background-color: #f8f9fa; border-radius: 8px;">
                        <div class="bg-success rounded p-2 me-3">
                            <i class="bi bi-heart text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Spa & Wellness</h6>
                            <small class="text-muted">Détente et bien-être</small>
                        </div>
                        <div>
                            <strong>89</strong>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3 p-2" style="background-color: #f8f9fa; border-radius: 8px;">
                        <div class="bg-warning rounded p-2 me-3">
                            <i class="bi bi-telephone text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Room Service</h6>
                            <small class="text-muted">Service en chambre</small>
                        </div>
                        <div>
                            <strong>67</strong>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3 p-2" style="background-color: #f8f9fa; border-radius: 8px;">
                        <div class="bg-info rounded p-2 me-3">
                            <i class="bi bi-car-front text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Valet Parking</h6>
                            <small class="text-muted">Service voiturier</small>
                        </div>
                        <div>
                            <strong>45</strong>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <a href="#" class="text-primary text-decoration-none">Voir Tous les Services</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            datasets: [{
                label: 'Réservations',
                data: [25, 35, 28, 45, 65, 55, 70],
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                fill: true,
                tension: 0.4
            }, {
                label: 'Revenus (x100€)',
                data: [40, 50, 45, 60, 75, 68, 85],
                borderColor: '#6c757d',
                backgroundColor: 'rgba(108, 117, 125, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                }
            }
        }
    });

    // Donut Chart
    const donutCtx = document.getElementById('donutChart').getContext('2d');
    const donutChart = new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Desktop', 'Tablette', 'Mobile'],
            datasets: [{
                data: [45, 32, 23],
                backgroundColor: ['#28a745', '#17a2b8', '#ffc107'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            cutout: '70%'
        }
    });
</script>

<style>
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }
    
    .progress {
        border-radius: 10px;
    }
    
    .badge {
        font-size: 0.75em;
    }
    
    .table td, .table th {
        vertical-align: middle;
    }
    
    .list-group-item {
        transition: background-color 0.2s;
    }
    
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection