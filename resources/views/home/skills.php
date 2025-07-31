<!DOCTYPE html>
<html lang="ar">
<head>
    <base target="_self">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المهارات | مهاراتي</title>
    <meta name="description" content="عرض المهارات والقدرات المهنية">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#2563eb",
                        secondary: "#1e40af",
                        accent: "#f97316"
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap');
        body {
            font-family: 'Tajawal', sans-serif;
            direction: rtl;
        }
        .skill-bar {
            height: 12px;
            border-radius: 6px;
            overflow: hidden;
        }
        .skill-level {
            height: 100%;
            border-radius: 6px;
        }
        .skill-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
<!-- Header -->
<header class="bg-white shadow-sm">
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <i class="fas fa-laptop-code text-primary text-2xl"></i>
                <h1 class="text-xl font-bold text-gray-900">مهاراتي</h1>
            </div>
            <nav>
                <ul class="flex space-x-6">
                    <li><a href="#" class="text-gray-600 hover:text-primary transition">الرئيسية</a></li>
                    <li><a href="#" class="text-primary font-medium">المهارات</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-primary transition">المشاريع</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-primary transition">الاتصال</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="container mx-auto px-4 py-12">
    <div class="text-center mb-16">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">مهاراتي وخبراتي</h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            مجموعة من المهارات التقنية والعملية التي اكتسبتها خلال مسيرتي المهنية
        </p>
    </div>

    <!-- Skills Categories -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
        <!-- Technical Skills -->
        <div class="bg-white rounded-xl shadow-md p-6 skill-card transition-all duration-300">
            <div class="flex items-center mb-6">
                <div class="bg-blue-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-code text-primary text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold">المهارات التقنية</h2>
            </div>

            <div class="space-y-6">
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">HTML/CSS</span>
                        <span>95%</span>
                    </div>
                    <div class="skill-bar bg-gray-200">
                        <div class="skill-level bg-primary" style="width: 95%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">JavaScript</span>
                        <span>90%</span>
                    </div>
                    <div class="skill-bar bg-gray-200">
                        <div class="skill-level bg-primary" style="width: 90%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">React</span>
                        <span>85%</span>
                    </div>
                    <div class="skill-bar bg-gray-200">
                        <div class="skill-level bg-primary" style="width: 85%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">Node.js</span>
                        <span>80%</span>
                    </div>
                    <div class="skill-bar bg-gray-200">
                        <div class="skill-level bg-primary" style="width: 80%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Design Skills -->
        <div class="bg-white rounded-xl shadow-md p-6 skill-card transition-all duration-300">
            <div class="flex items-center mb-6">
                <div class="bg-purple-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-paint-brush text-purple-600 text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold">مهارات التصميم</h2>
            </div>

            <div class="space-y-6">
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">UI/UX Design</span>
                        <span>90%</span>
                    </div>
                    <div class="skill-bar bg-gray-200">
                        <div class="skill-level bg-purple-600" style="width: 90%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">Figma</span>
                        <span>85%</span>
                    </div>
                    <div class="skill-bar bg-gray-200">
                        <div class="skill-level bg-purple-600" style="width: 85%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">Photoshop</span>
                        <span>75%</span>
                    </div>
                    <div class="skill-bar bg-gray-200">
                        <div class="skill-level bg-purple-600" style="width: 75%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">Illustrator</span>
                        <span>70%</span>
                    </div>
                    <div class="skill-bar bg-gray-200">
                        <div class="skill-level bg-purple-600" style="width: 70%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Soft Skills -->
        <div class="bg-white rounded-xl shadow-md p-6 skill-card transition-all duration-300">
            <div class="flex items-center mb-6">
                <div class="bg-orange-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-users text-accent text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold">المهارات الشخصية</h2>
            </div>

            <div class="space-y-6">
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">القيادة</span>
                        <span>85%</span>
                    </div>
                    <div class="skill-bar bg-gray-200">
                        <div class="skill-level bg-accent" style="width: 85%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">العمل الجماعي</span>
                        <span>95%</span>
                    </div>
                    <div class="skill-bar bg-gray-200">
                        <div class="skill-level bg-accent" style="width: 95%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">حل المشكلات</span>
                        <span>90%</span>
                    </div>
                    <div class="skill-bar bg-gray-200">
                        <div class="skill-level bg-accent" style="width: 90%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">التواصل</span>
                        <span>88%</span>
                    </div>
                    <div class="skill-bar bg-gray-200">
                        <div class="skill-level bg-accent" style="width: 88%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Skills -->
    <div class="bg-white rounded-xl shadow-md p-8 mb-16">
        <h2 class="text-3xl font-bold mb-8 text-center">مهارات إضافية</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center p-6 bg-gray-50 rounded-lg">
                <i class="fab fa-git-alt text-4xl text-orange-500 mb-4"></i>
                <h3 class="font-bold text-lg">Git</h3>
            </div>

            <div class="text-center p-6 bg-gray-50 rounded-lg">
                <i class="fab fa-docker text-4xl text-blue-500 mb-4"></i>
                <h3 class="font-bold text-lg">Docker</h3>
            </div>

            <div class="text-center p-6 bg-gray-50 rounded-lg">
                <i class="fas fa-database text-4xl text-green-500 mb-4"></i>
                <h3 class="font-bold text-lg">SQL</h3>
            </div>

            <div class="text-center p-6 bg-gray-50 rounded-lg">
                <i class="fab fa-aws text-4xl text-yellow-500 mb-4"></i>
                <h3 class="font-bold text-lg">AWS</h3>
            </div>
        </div>
    </div>

    <!-- Certifications -->
    <div class="text-center">
        <h2 class="text-3xl font-bold mb-8">الشهادات والدورات</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-primary">
                <h3 class="font-bold text-xl mb-2">تطوير الويب المتقدم</h3>
                <p class="text-gray-600 mb-4">معهد التقنية الحديثة</p>
                <p class="text-sm text-gray-500">2023</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-accent">
                <h3 class="font-bold text-xl mb-2">UI/UX Design</h3>
                <p class="text-gray-600 mb-4">أكاديمية التصميم الإبداعي</p>
                <p class="text-sm text-gray-500">2022</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-purple-600">
                <h3 class="font-bold text-xl mb-2">إدارة المشاريع</h3>
                <p class="text-gray-600 mb-4">معهد إدارة الأعمال</p>
                <p class="text-sm text-gray-500">2021</p>
            </div>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="bg-gray-800 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="mb-6 md:mb-0">
                <h3 class="text-2xl font-bold">مهاراتي</h3>
                <p class="text-gray-400 mt-2">تطوير المهارات لتحقيق الأهداف</p>
            </div>

            <div class="flex space-x-6">
                <a href="#" class="text-gray-400 hover:text-white transition">
                    <i class="fab fa-linkedin-in text-xl"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition">
                    <i class="fab fa-github text-xl"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition">
                    <i class="fab fa-twitter text-xl"></i>
                </a>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
            <p>© 2023 جميع الحقوق محفوظة</p>
        </div>
    </div>
</footer>
</body>
</html>