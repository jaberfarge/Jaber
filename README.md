<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مستكشف النفايات الذكي</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <!-- Google GenAI -->
    <script type="importmap">
    {
      "imports": {
        "@google/genai": "https://esm.run/@google/genai"
      }
    }
    </script>

    <style>
        body { background-color: #0A0A0B; color: #E1E1E3; }
        .scanning-line {
            position: absolute; left: 0; right: 0; height: 2px;
            background: linear-gradient(to right, transparent, #10B981, transparent);
            animation: scan 2s linear infinite;
        }
        @keyframes scan { from { top: 0%; } to { top: 100%; } }
    </style>
</head>
<body class="min-h-screen">

    <main class="max-w-md mx-auto px-6 py-8 space-y-6">

        <!-- Header -->
        <header class="text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 mb-3">
                <i data-lucide="trash-2" class="w-6 h-6 text-emerald-400"></i>
            </div>
            <h1 class="text-2xl font-bold text-white mb-1">مستكشف النفايات الذكي</h1>
            <p class="text-sm text-gray-400">فحص النفايات، حساب القيمة، ونصائح ذكية</p>
        </header>

        <!-- Camera / Image -->
        <section class="relative aspect-[3/4] bg-[#151619] rounded-3xl overflow-hidden border border-white/5">
            <video id="video" autoplay playsinline muted class="w-full h-full object-cover"></video>
            <img id="preview" class="hidden w-full h-full object-cover">
            <div id="scanner" class="hidden scanning-line"></div>
        </section>

        <!-- Actions -->
        <section class="space-y-3">
            <div class="flex gap-3">
                <button id="analyzeBtn" class="flex-1 bg-emerald-500 hover:bg-emerald-400 text-black py-4 rounded-xl font-bold flex items-center justify-center gap-2">
                    <i data-lucide="camera" class="w-5 h-5"></i>
                    <span>فحص الصورة</span>
                </button>
                <button id="uploadBtn" class="w-14 bg-[#1C1D21] hover:bg-[#25262B] text-white rounded-xl flex items-center justify-center">
                    <i data-lucide="image" class="w-5 h-5"></i>
                </button>
                <input type="file" id="fileInput" class="hidden" accept="image/*">
            </div>

            <div class="flex gap-3">
                <button id="historyBtn" class="flex-1 bg-[#1C1D21] hover:bg-[#25262B] text-white py-3 rounded-xl flex items-center justify-center gap-2 text-sm">
                    <i data-lucide="history" class="w-4 h-4"></i>
                    <span>السجل</span>
                </button>
                <button id="exportBtn" class="flex-1 bg-[#1C1D21] hover:bg-[#25262B] text-white py-3 rounded-xl flex items-center justify-center gap-2 text-sm">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    <span>تصدير Excel</span>
                </button>
            </div>
        </section>

        <!-- Results -->
        <section id="resultsContainer" class="space-y-3"></section>

        <!-- Dashboard -->
        <section id="dashboard" class="space-y-3">
            <h2 class="text-lg font-bold">لوحة المتابعة</h2>
            <div id="stats" class="grid grid-cols-2 gap-3 text-sm"></div>
        </section>

    </main>

<script type="module">
import { GoogleGenAI } from "@google/genai";

const API_KEY = "ضع_مفتاح_GEMINI_هنا";
const STORAGE_KEY = "waste_scanner_history";
const POINTS_KEY = "waste_scanner_points";

// جدول تقديري للأنواع (مثال)
const WASTE_TABLE = {
    "بلاستيك": { pricePerKg: 2, avgWeight: 0.1 },
    "حديد":   { pricePerKg: 5, avgWeight: 0.5 },
    "ورق":    { pricePerKg: 1, avgWeight: 0.2 }
};

let history = JSON.parse(localStorage.getItem(STORAGE_KEY) || "[]");
if (!Array.isArray(history)) history = [];

let points = Number(localStorage.getItem(POINTS_KEY) || "0");

// عناصر الواجهة
const video = document.getElementById("video");
const preview = document.getElementById("preview");
const scanner = document.getElementById("scanner");
const analyzeBtn = document.getElementById("analyzeBtn");
const uploadBtn = document.getElementById("uploadBtn");
const fileInput = document.getElementById("fileInput");
const resultsContainer = document.getElementById("resultsContainer");
const exportBtn = document.getElementById("exportBtn");
const historyBtn = document.getElementById("historyBtn");
const statsDiv = document.getElementById("stats");

// تشغيل الكاميرا
async function startCamera() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: "environment" }
        });
        video.srcObject = stream;
        video.classList.remove("hidden");
        preview.classList.add("hidden");
    } catch (err) {
        alert("تعذر الوصول للكاميرا");
    }
}

// تحسين العناصر (وزن + سعر)
function enrichItems(items) {
    return items.map(item => {
        const type = item.type || item.name || "";
        let matchedKey = Object.keys(WASTE_TABLE).find(k => type.includes(k)) || null;
        const info = matchedKey ? WASTE_TABLE[matchedKey] : { pricePerKg: 0, avgWeight: 0.1 };

        const weight = info.avgWeight;
        const price = weight * info.pricePerKg;

        return {
            ...item,
            weight: `${weight.toFixed(2)} كجم`,
            price: `${price.toFixed(2)} ريال`
        };
    });
}

// وكيل الذكاء الاصطناعي
async function runAgent(data) {
    const genAI = new GoogleGenAI(API_KEY);
    const model = genAI.getGenerativeModel({ model: "gemini-1.5-flash" });

    const agentPrompt = `
    أنت وكيل ذكاء اصطناعي متخصص في إدارة النفايات.
    هذه بيانات النفايات:
    ${JSON.stringify(data, null, 2)}

    المطلوب:
    - اكتب ملخصًا قصيرًا عن حالة النفايات.
    - أعطِ المستخدم 3 نصائح عملية لإعادة التدوير أو التقليل.
    أرجع الرد كنص عربي فقط.
    `;

    const result = await model.generateContent(agentPrompt);
    return result.response.text();
}

// نظام النقاط
function addPointsForScan(data) {
    let added = 0;
    added += (data.totalCount || 0) * 5;

    data.items.forEach(item => {
        if (item.name?.includes("بلاستيك")) added += 2;
        if (item.name?.includes("حديد")) added += 3;
    });

    points += added;
    localStorage.setItem(POINTS_KEY, points);
    showPoints(added);
}

function showPoints(added) {
    resultsContainer.innerHTML += `
        <div class="mt-3 bg-blue-500/10 border border-blue-500/30 rounded-2xl p-3 text-xs text-blue-100">
            حصلت على <span class="font-bold">${added}</span> نقطة في هذا الفحص.  
            مجموع نقاطك الآن: <span class="font-bold">${points}</span>
        </div>
    `;
}

// Dashboard
function updateDashboard() {
    const totalScans = history.length;
    const totalItems = history.reduce((sum, h) => sum + (h.totalCount || 0), 0);
    const lastScan = history[0]?.timestamp || "لا يوجد";

    statsDiv.innerHTML = `
        <div class="bg-[#151619] p-3 rounded-xl border border-white/5">
            <p class="text-gray-400 text-xs">عدد الفحوصات</p>
            <p class="text-lg font-bold">${totalScans}</p>
        </div>
        <div class="bg-[#151619] p-3 rounded-xl border border-white/5">
            <p class="text-gray-400 text-xs">إجمالي العناصر</p>
            <p class="text-lg font-bold">${totalItems}</p>
        </div>
        <div class="bg-[#151619] p-3 rounded-xl border border-white/5">
            <p class="text-gray-400 text-xs">النقاط</p>
            <p class="text-lg font-bold">${points}</p>
        </div>
        <div class="bg-[#151619] p-3 rounded-xl border border-white/5">
            <p class="text-gray-400 text-xs">آخر فحص</p>
            <p class="text-[11px]">${lastScan}</p>
        </div>
    `;
}

// عرض النتائج
function renderResults(data) {
    resultsContainer.innerHTML = `
        <div class="bg-[#151619] p-5 rounded-2xl border border-white/5">
            <h2 class="text-lg font-bold mb-3">نتائج الفحص</h2>
            <p class="text-sm text-gray-400 mb-4">${data.summary}</p>

            ${data.items.map(item => `
                <div class="bg-white/5 p-3 rounded-xl mb-2">
                    <div class="flex justify-between text-xs font-bold">
                        <span>${item.name}</span>
                        <span class="text-emerald-400">${item.price}</span>
                    </div>
                    <p class="text-[10px] text-gray-400">الوزن: ${item.weight}</p>
                </div>
            `).join("")}
        </div>
    `;
}

// إضافة نص الوكيل
function appendAgentAdvice(text) {
    resultsContainer.innerHTML += `
        <div class="mt-4 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl p-4 text-sm text-emerald-100">
            <h3 class="font-bold mb-2">نصيحة المساعد الذكي</h3>
            <p>${text}</p>
        </div>
    `;
}

// تحليل الصورة
async function analyze() {
    resultsContainer.innerHTML = "";
    scanner.classList.remove("hidden");
    analyzeBtn.disabled = true;
    analyzeBtn.innerText = "جاري التحليل...";

    let base64 = null;

    if (!preview.classList.contains("hidden") && preview.src) {
        // من الصورة المرفوعة
        const img = new Image();
        img.src = preview.src;
        await img.decode();
        const canvas = document.createElement("canvas");
        canvas.width = img.width;
        canvas.height = img.height;
        canvas.getContext("2d").drawImage(img, 0, 0);
        base64 = canvas.toDataURL("image/jpeg").split(",")[1];
    } else {
        // من الكاميرا
        if (video.videoWidth === 0) {
            alert("الكاميرا غير جاهزة");
            resetAnalyzeButton();
            return;
        }
        const canvas = document.createElement("canvas");
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext("2d").drawImage(video, 0, 0);
        base64 = canvas.toDataURL("image/jpeg").split(",")[1];
    }

    try {
        const genAI = new GoogleGenAI(API_KEY);
        const model = genAI.getGenerativeModel({ model: "gemini-1.5-flash" });

        const prompt = `
        حلل هذه الصورة كنفايات.
        أرجع JSON فقط بالشكل:
        {
          "summary": "ملخص بالعربي",
          "totalCount": رقم,
          "items": [
            { "name": "اسم العنصر", "type": "نوع النفاية" }
          ]
        }
        لا تضف أي نص خارج JSON.
        `;

        const result = await model.generateContent([
            prompt,
            { inlineData: { data: base64, mimeType: "image/jpeg" } }
        ]);

        let raw = result.response.text();
        raw = raw.replace(/```json/g, "").replace(/```/g, "").trim();

        let data;
        try {
            data = JSON.parse(raw);
        } catch (e) {
            console.error("JSON Error:", raw);
            alert("خطأ في قراءة بيانات الذكاء الاصطناعي");
            resetAnalyzeButton();
            scanner.classList.add("hidden");
            return;
        }

        data.items = enrichItems(data.items || []);
        data.timestamp = new Date().toLocaleString("ar-EG");

        history.unshift(data);
        localStorage.setItem(STORAGE_KEY, JSON.stringify(history));

        renderResults(data);
        addPointsForScan(data);
        updateDashboard();

        const agentText = await runAgent(data);
        appendAgentAdvice(agentText);

    } catch (err) {
        console.error(err);
        alert("حدث خطأ أثناء التحليل");
    }

    resetAnalyzeButton();
    scanner.classList.add("hidden");
}

function resetAnalyzeButton() {
    analyzeBtn.disabled = false;
    analyzeBtn.innerText = "فحص الصورة";
}

// رفع صورة
uploadBtn.onclick = () => fileInput.click();

fileInput.onchange = (e) => {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = () => {
        preview.src = reader.result;
        preview.classList.remove("hidden");
        video.classList.add("hidden");
        resultsContainer.innerHTML = "";
    };
    reader.readAsDataURL(file);
};

// تصدير Excel
exportBtn.onclick = () => {
    if (!history.length) {
        alert("لا يوجد بيانات للتصدير");
        return;
    }
    const rows = history.flatMap(h =>
        (h.items || []).map(item => ({
            timestamp: h.timestamp,
            summary: h.summary,
            name: item.name,
            weight: item.weight,
            price: item.price
        }))
    );
    const ws = XLSX.utils.json_to_sheet(rows);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Waste");
    XLSX.writeFile(wb, "waste_report.xlsx");
};

// عرض السجل
historyBtn.onclick = () => {
    if (!history.length) {
        alert("لا يوجد سجل بعد");
        return;
    }
    const last = history[0];
    renderResults(last);
    appendAgentAdvice("عرض آخر نتيجة من السجل.");
};

// تشغيل
analyzeBtn.onclick = analyze;
startCamera();
updateDashboard();
lucide.createIcons();
</script>

</body>
</html>
