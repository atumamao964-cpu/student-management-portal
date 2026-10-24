<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        rose: {
                            50: '#fff1f2', 100: '#ffe4e6', 200: '#fecdd3', 300: '#fda4af',
                            400: '#fb7185', 500: '#f43f5e', 600: '#e11d48', 700: '#be123c'
                        },
                        stone: {
                            50: '#fafaf9', 100: '#f5f5f4', 200: '#e7e5e4', 300: '#d6d3d1',
                            400: '#a8a29e', 500: '#78716c', 600: '#57534e', 700: '#44403c',
                            800: '#292524', 900: '#1c1917'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', system-ui, sans-serif; background: #fafaf9; }
        .card { background: white; border-radius: 1rem; border: 1px solid #e7e5e4; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
        .btn-primary {
            background: linear-gradient(135deg, #f43f5e, #e11d48);
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #e11d48, #be123c);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(244, 63, 94, 0.25);
        }
        .input-field {
            border: 1px solid #e7e5e4;
            transition: all 0.2s;
        }
        .input-field:focus {
            border-color: #f43f5e;
            box-shadow: 0 0 0 3px rgba(244, 63, 94, 0.12);
            outline: none;
        }
        .stat-card { transition: all 0.2s ease; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.06); }
    </style>
</head>
<body class="min-h-screen text-stone-800">

<!-- Header -->
<header class="bg-white border-b border-stone-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-400 to-rose-600 flex items-center justify-center shadow-sm">
                    <i class="fas fa-graduation-cap text-white"></i>
                </div>
                <div>
                    <h1 class="text-lg font-semibold text-stone-800 tracking-tight">Student Portal</h1>
                    <p class="text-xs text-stone-400 -mt-0.5">Manage students, courses & more</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button class="relative p-2 text-stone-400 hover:text-stone-600 transition">
                    <i class="fas fa-bell"></i>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full"></span>
                </button>
                <div class="flex items-center gap-2.5 pl-4 border-l border-stone-200">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-rose-400 to-rose-600 flex items-center justify-center text-white text-xs font-semibold">
                        AD
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-sm font-medium text-stone-700">Admin</p>
                        <p class="text-xs text-stone-400">Administrator</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
