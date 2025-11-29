<?php

use Illuminate\Support\Facades\Schedule;

// Jalankan command publish setiap 1 menit
Schedule::command('posts:publish-scheduled')->everyMinute();
