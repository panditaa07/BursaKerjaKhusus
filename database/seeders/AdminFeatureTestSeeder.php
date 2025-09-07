<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Company;
use App\Models\JobPost;
use App\Models\Application;
use Carbon\Carbon;

class AdminFeatureTestSeeder extends Seeder
{
    public function run()
    {
        // Clear existing test data first (in correct order due to foreign keys)
        \App\Models\Application::query()->forceDelete();
        \App\Models\JobPost::query()->forceDelete();
        \App\Models\Company::query()->forceDelete();
        \App\Models\User::where('role', 'company')->forceDelete();
        \App\Models\User::where('role', 'user')->forceDelete();
        \App\Models\User::where('role', 'admin')->forceDelete();

        // Create admin user
        $admin = User::create([
            'name' => 'Admin BKK',
            'email' => 'admin@bkk.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create company users
        $companyUsers = [
            [
                'name' => 'HR Manager Teknologi',
                'email' => 'hr@teknologimaju.com',
                'password' => Hash::make('password'),
                'role' => 'company',
                'phone' => '081234567890',
                'address' => 'Jl. Teknologi No. 123, Jakarta',
            ],
            [
                'name' => 'Recruiter Finansial',
                'email' => 'recruiter@finansialindonesia.com',
                'password' => Hash::make('password'),
                'role' => 'company',
                'phone' => '081987654321',
                'address' => 'Jl. Keuangan No. 456, Jakarta',
            ],
            [
                'name' => 'HR Kesehatan',
                'email' => 'hr@kesehatan.com',
                'password' => Hash::make('password'),
                'role' => 'company',
                'phone' => '081112233445',
                'address' => 'Jl. Kesehatan No. 789, Jakarta',
            ],
        ];

        $createdUsers = [];
        foreach ($companyUsers as $userData) {
            $createdUsers[] = User::create($userData);
        }

        // Create companies
        $companies = [
            [
                'user_id' => $createdUsers[0]->id,
                'name' => 'PT Teknologi Maju',
                'phone' => '021-12345678',
                'address' => 'Jl. Teknologi No. 123, Jakarta',
                'description' => 'Perusahaan teknologi terkemuka di Indonesia',
                'is_verified' => true,
            ],
            [
                'user_id' => $createdUsers[1]->id,
                'name' => 'PT Finansial Indonesia',
                'phone' => '021-87654321',
                'address' => 'Jl. Keuangan No. 456, Jakarta',
                'description' => 'Bank dan layanan keuangan terpercaya',
                'is_verified' => true,
            ],
            [
                'user_id' => $createdUsers[2]->id,
                'name' => 'PT Kesehatan Sejahtera',
                'phone' => '021-11223344',
                'address' => 'Jl. Kesehatan No. 789, Jakarta',
                'description' => 'Rumah sakit dan layanan kesehatan modern',
                'is_verified' => true,
            ],
        ];

        $createdCompanies = [];
        foreach ($companies as $companyData) {
            $createdCompanies[] = Company::create($companyData);
        }

        // Create user applicants (some from this month, some from previous months)
        $userApplicants = [
            [
                'name' => 'Ahmad Rahman',
                'email' => 'ahmad.rahman@email.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'nisn' => '1234567890',
                'phone' => '081234567891',
                'address' => 'Jl. Sudirman No. 100, Jakarta',
                'graduation_year' => 2023,
                'social_media_link' => 'https://linkedin.com/in/ahmadrahman',
                'profile_photo_path' => null,
                'short_profile' => 'Fresh graduate Teknik Informatika dengan keahlian web development',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@email.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'nisn' => '1234567891',
                'phone' => '081234567892',
                'address' => 'Jl. Thamrin No. 200, Jakarta',
                'graduation_year' => 2022,
                'social_media_link' => 'https://linkedin.com/in/sitinurhaliza',
                'profile_photo_path' => null,
                'short_profile' => 'Mahasiswa semester akhir dengan pengalaman magang di perusahaan IT',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@email.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'nisn' => '1234567892',
                'phone' => '081234567893',
                'address' => 'Jl. Gatot Subroto No. 300, Jakarta',
                'graduation_year' => 2023,
                'social_media_link' => 'https://linkedin.com/in/budisantoso',
                'profile_photo_path' => null,
                'short_profile' => 'Pengembang aplikasi mobile dengan pengalaman 1 tahun',
            ],
            [
                'name' => 'Maya Sari',
                'email' => 'maya.sari@email.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'nisn' => '1234567893',
                'phone' => '081234567894',
                'address' => 'Jl. MH Thamrin No. 400, Jakarta',
                'graduation_year' => 2021,
                'social_media_link' => 'https://linkedin.com/in/mayasari',
                'profile_photo_path' => null,
                'short_profile' => 'Data analyst dengan keahlian SQL dan Python',
            ],
            [
                'name' => 'Rizki Pratama',
                'email' => 'rizki.pratama@email.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'nisn' => '1234567894',
                'phone' => '081234567895',
                'address' => 'Jl. Sudirman No. 500, Jakarta',
                'graduation_year' => 2023,
                'social_media_link' => 'https://linkedin.com/in/rizkipratama',
                'profile_photo_path' => null,
                'short_profile' => 'UI/UX Designer dengan portfolio yang solid',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.lestari@email.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'nisn' => '1234567895',
                'phone' => '081234567896',
                'address' => 'Jl. Sudirman No. 600, Jakarta',
                'graduation_year' => 2023,
                'social_media_link' => 'https://linkedin.com/in/dewilestari',
                'profile_photo_path' => null,
                'short_profile' => 'Fresh graduate dengan keahlian networking',
            ],
            [
                'name' => 'Agus Setiawan',
                'email' => 'agus.setiawan@email.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'nisn' => '1234567896',
                'phone' => '081234567897',
                'address' => 'Jl. Sudirman No. 700, Jakarta',
                'graduation_year' => 2023,
                'social_media_link' => 'https://linkedin.com/in/agussetiawan',
                'profile_photo_path' => null,
                'short_profile' => 'System administrator dengan pengalaman 2 tahun',
            ],
        ];

        $createdUserApplicants = [];
        foreach ($userApplicants as $userData) {
            $createdUserApplicants[] = User::create($userData);
        }

        // Create job posts (mix of active and closed)
        $jobPosts = [
            [
                'company_id' => $createdCompanies[0]->id,
                'title' => 'Web Developer',
                'description' => 'Kami mencari Web Developer yang berpengalaman dalam pengembangan aplikasi web menggunakan Laravel dan React.js.',
                'requirements' => '• Pengalaman minimal 2 tahun dalam web development
• Menguasai Laravel dan React.js
• Menguasai database MySQL/PostgreSQL
• Menguasai HTML, CSS, JavaScript
• Menguasai Git dan version control
• Kemampuan problem solving yang baik
• Komunikasi yang baik',
                'location' => 'Jakarta Pusat',
                'employment_type' => 'full_time',
                'vacancies' => 3,
                'deadline' => now()->addDays(30),
                'salary' => 'Rp 8.000.000 - Rp 12.000.000',
                'status' => 'active',
            ],
            [
                'company_id' => $createdCompanies[0]->id,
                'title' => 'Mobile App Developer',
                'description' => 'Bergabunglah dengan tim kami sebagai Mobile App Developer.',
                'requirements' => '• Pengalaman minimal 1 tahun dalam mobile development
• Menguasai React Native atau Flutter
• Menguasai JavaScript/TypeScript
• Pengalaman dengan REST API
• Menguasai Git
• Kemampuan analisis dan problem solving',
                'location' => 'Jakarta Selatan',
                'employment_type' => 'full_time',
                'vacancies' => 2,
                'deadline' => now()->addDays(25),
                'salary' => 'Rp 9.000.000 - Rp 15.000.000',
                'status' => 'active',
            ],
            [
                'company_id' => $createdCompanies[1]->id,
                'title' => 'Data Analyst',
                'description' => 'Posisi Data Analyst untuk menganalisis data keuangan.',
                'requirements' => '• Pengalaman minimal 1 tahun sebagai data analyst
• Menguasai SQL dan database
• Menguasai Excel dan Google Sheets
• Pengalaman dengan Python atau R untuk data analysis
• Menguasai tools seperti Tableau atau Power BI
• Kemampuan presentasi data yang baik',
                'location' => 'Jakarta Pusat',
                'employment_type' => 'full_time',
                'vacancies' => 1,
                'deadline' => now()->addDays(20),
                'salary' => 'Rp 7.000.000 - Rp 10.000.000',
                'status' => 'active',
            ],
            [
                'company_id' => $createdCompanies[2]->id,
                'title' => 'IT Support Staff',
                'description' => 'Bergabunglah sebagai IT Support Staff di rumah sakit terkemuka.',
                'requirements' => '• Diploma/Sarjana Teknik Informatika/Sistem Informasi
• Pengalaman minimal 1 tahun di bidang IT support
• Menguasai troubleshooting hardware dan software
• Menguasai jaringan komputer
• Menguasai Microsoft Office
• Kemampuan komunikasi yang baik',
                'location' => 'Jakarta Timur',
                'employment_type' => 'full_time',
                'vacancies' => 2,
                'deadline' => now()->addDays(15),
                'salary' => 'Rp 5.000.000 - Rp 7.000.000',
                'status' => 'active',
            ],
            [
                'company_id' => $createdCompanies[0]->id,
                'title' => 'UI/UX Designer',
                'description' => 'Kami mencari UI/UX Designer yang kreatif dan berpengalaman.',
                'requirements' => '• Pengalaman minimal 2 tahun sebagai UI/UX Designer
• Menguasai Figma, Adobe XD, atau Sketch
• Menguasai prototyping tools
• Memahami user experience principles
• Kemampuan visual design yang baik
• Portfolio yang menarik',
                'location' => 'Jakarta Pusat',
                'employment_type' => 'full_time',
                'vacancies' => 1,
                'deadline' => now()->addDays(35),
                'salary' => 'Rp 8.000.000 - Rp 13.000.000',
                'status' => 'active',
            ],
            [
                'company_id' => $createdCompanies[0]->id,
                'title' => 'System Administrator',
                'description' => 'Posisi System Administrator untuk mengelola infrastruktur IT perusahaan.',
                'requirements' => '• Pengalaman minimal 2 tahun sebagai system administrator
• Menguasai Linux/Windows Server
• Menguasai networking dan security
• Pengalaman dengan cloud services (AWS/Azure)
• Menguasai scripting (Bash/Python)
• Sertifikasi IT yang relevan',
                'location' => 'Jakarta Pusat',
                'employment_type' => 'full_time',
                'vacancies' => 1,
                'deadline' => now()->addDays(28),
                'salary' => 'Rp 10.000.000 - Rp 15.000.000',
                'status' => 'active',
            ],
            // Closed job posts
            [
                'company_id' => $createdCompanies[1]->id,
                'title' => 'Frontend Developer',
                'description' => 'Posisi Frontend Developer untuk pengembangan aplikasi web.',
                'requirements' => '• Pengalaman minimal 1 tahun sebagai frontend developer
• Menguasai HTML, CSS, JavaScript
• Menguasai framework seperti React atau Vue.js
• Menguasai Git
• Kemampuan problem solving yang baik',
                'location' => 'Jakarta Pusat',
                'employment_type' => 'full_time',
                'vacancies' => 2,
                'deadline' => now()->subDays(5),
                'salary' => 'Rp 6.000.000 - Rp 9.000.000',
                'status' => 'closed',
            ],
            [
                'company_id' => $createdCompanies[2]->id,
                'title' => 'Network Engineer',
                'description' => 'Posisi Network Engineer untuk mengelola infrastruktur jaringan.',
                'requirements' => '• Pengalaman minimal 2 tahun sebagai network engineer
• Menguasai Cisco networking
• Menguasai firewall dan security
• Sertifikasi CCNA/CCNP
• Kemampuan troubleshooting jaringan',
                'location' => 'Jakarta Timur',
                'employment_type' => 'full_time',
                'vacancies' => 1,
                'deadline' => now()->subDays(10),
                'salary' => 'Rp 8.000.000 - Rp 12.000.000',
                'status' => 'closed',
            ],
        ];

        $createdJobPosts = [];
        foreach ($jobPosts as $jobData) {
            $createdJobPosts[] = JobPost::create($jobData);
        }

        // Create applications with different dates (some this month, some previous)
        $applications = [
            // This month applications
            [
                'user_id' => $createdUserApplicants[0]->id,
                'job_post_id' => $createdJobPosts[0]->id,
                'cv_path' => null,
                'application_letter_path' => null,
                'cover_letter' => 'Saya sangat tertarik dengan posisi Web Developer di PT Teknologi Maju.',
                'status' => 'submitted',
                'created_at' => now()->subDays(3),
            ],
            [
                'user_id' => $createdUserApplicants[1]->id,
                'job_post_id' => $createdJobPosts[0]->id,
                'cv_path' => null,
                'application_letter_path' => null,
                'cover_letter' => 'Sebagai fresh graduate dengan keahlian dalam web development.',
                'status' => 'submitted',
                'created_at' => now()->subDays(5),
            ],
            [
                'user_id' => $createdUserApplicants[2]->id,
                'job_post_id' => $createdJobPosts[1]->id,
                'cv_path' => null,
                'application_letter_path' => null,
                'cover_letter' => 'Dengan pengalaman saya dalam networking dan sistem informasi.',
                'status' => 'accepted',
                'created_at' => now()->subDays(7),
            ],
            [
                'user_id' => $createdUserApplicants[3]->id,
                'job_post_id' => $createdJobPosts[2]->id,
                'cv_path' => null,
                'application_letter_path' => null,
                'cover_letter' => 'Sebagai lulusan dengan spesialisasi data analysis.',
                'status' => 'rejected',
                'created_at' => now()->subDays(10),
            ],
            [
                'user_id' => $createdUserApplicants[4]->id,
                'job_post_id' => $createdJobPosts[4]->id,
                'cv_path' => null,
                'application_letter_path' => null,
                'cover_letter' => 'Dengan pengalaman saya sebagai full-stack developer.',
                'status' => 'submitted',
                'created_at' => now()->subDays(2),
            ],
            [
                'user_id' => $createdUserApplicants[5]->id,
                'job_post_id' => $createdJobPosts[3]->id,
                'cv_path' => null,
                'application_letter_path' => null,
                'cover_letter' => 'Fresh graduate dengan keahlian networking.',
                'status' => 'submitted',
                'created_at' => now()->subDays(1),
            ],
            [
                'user_id' => $createdUserApplicants[6]->id,
                'job_post_id' => $createdJobPosts[5]->id,
                'cv_path' => null,
                'application_letter_path' => null,
                'cover_letter' => 'System administrator dengan pengalaman 2 tahun.',
                'status' => 'submitted',
                'created_at' => now()->subDays(4),
            ],
            // Previous month applications
            [
                'user_id' => $createdUserApplicants[0]->id,
                'job_post_id' => $createdJobPosts[6]->id,
                'cv_path' => null,
                'application_letter_path' => null,
                'cover_letter' => 'Pengalaman sebagai frontend developer.',
                'status' => 'accepted',
                'created_at' => now()->subDays(35),
            ],
            [
                'user_id' => $createdUserApplicants[1]->id,
                'job_post_id' => $createdJobPosts[7]->id,
                'cv_path' => null,
                'application_letter_path' => null,
                'cover_letter' => 'Pengalaman sebagai network engineer.',
                'status' => 'rejected',
                'created_at' => now()->subDays(40),
            ],
        ];

        foreach ($applications as $applicationData) {
            Application::create($applicationData);
        }

        $this->command->info('Admin feature test data created successfully!');
        $this->command->info('Created:');
        $this->command->info('- 1 admin user');
        $this->command->info('- 3 companies');
        $this->command->info('- 3 company users');
        $this->command->info('- 7 user applicants');
        $this->command->info('- 8 job posts (6 active, 2 closed)');
        $this->command->info('- 9 applications (7 this month, 2 previous month)');
        $this->command->info('');
        $this->command->info('Test accounts:');
        $this->command->info('Admin: admin@bkk.com / password');
        $this->command->info('Company users:');
        $this->command->info('- hr@teknologimaju.com / password');
        $this->command->info('- recruiter@finansialindonesia.com / password');
        $this->command->info('- hr@kesehatan.com / password');
        $this->command->info('User applicants:');
        $this->command->info('- ahmad.rahman@email.com / password');
        $this->command->info('- siti.nurhaliza@email.com / password');
        $this->command->info('- budi.santoso@email.com / password');
        $this->command->info('- maya.sari@email.com / password');
        $this->command->info('- rizki.pratama@email.com / password');
        $this->command->info('- dewi.lestari@email.com / password');
        $this->command->info('- agus.setiawan@email.com / password');
    }
}
