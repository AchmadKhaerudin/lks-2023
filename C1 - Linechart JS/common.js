class LineChart {
    constructor({ title, data, canvasId }) {
        this.canvas = document.getElementById(canvasId);
        this.ctx = this.canvas.getContext('2d');
        this.title = title;
        this.dataRaw = data;

        // Dimensi Standar
        this.width = 600;
        this.height = 400;
        this.canvas.width = this.width;
        this.canvas.height = this.height;

        // Konfigurasi Margin/Padding
        this.padding = 65; 
        
        // Data Processing
        this.data = {
            values: [],
            highest: 0,
            length: 0
        };

        this.render();
    }

    render() {
        this.calcData();
        this.drawBackground();
        this.drawAxes();
        this.drawContent();
    }

    calcData() {
        this.data.values = this.dataRaw.map(item => item.jumlah);
        this.data.length = this.data.values.length;
        
        // Mencari nilai tertinggi dan dibulatkan ke atas untuk ruang skala
        const maxRaw = Math.max(...this.data.values);
        this.data.highest = Math.ceil(maxRaw / 10) * 10 || 10;
    }

    drawBackground() {
        this.ctx.fillStyle = '#ffffff';
        this.ctx.fillRect(0, 0, this.width, this.height);
    }

    drawAxes() {
        const { ctx, width, height, padding, data, title } = this;
        const yLength = height - (padding * 2);

        // --- 1. JUDUL GRAFIK ---
        ctx.fillStyle = '#2d3436';
        ctx.font = 'bold 20px Arial';
        ctx.textAlign = 'center';
        ctx.fillText(title, width / 2, 35);

        // --- 2. GARIS SUMBU (X & Y) ---
        ctx.beginPath();
        ctx.strokeStyle = '#636e72';
        ctx.lineWidth = 2;
        // Vertikal (Y)
        ctx.moveTo(padding, padding);
        ctx.lineTo(padding, height - padding);
        // Horizontal (X)
        ctx.lineTo(width - padding, height - padding);
        ctx.stroke();

        // --- 3. LABEL UNIT ---
        ctx.fillStyle = '#0984e3';
        ctx.font = 'bold 12px Arial';
        // Label Sumbu Y
        ctx.textAlign = 'center';
        ctx.fillText("JUMLAH", padding, padding - 20);
        // Label Sumbu X
        ctx.textAlign = 'left';
        ctx.fillText("TANGGAL", width - padding + 5, height - padding + 5);

        // --- 4. SKALA ANGKA SUMBU Y ---
        ctx.fillStyle = '#636e72';
        ctx.font = '11px Arial';
        ctx.textAlign = 'right';
        ctx.textBaseline = 'middle';

        const steps = 5;
        for (let i = 0; i <= steps; i++) {
            const val = (data.highest / steps) * i;
            const y = (height - padding) - (val / data.highest * yLength);
            
            // Angka Skala
            ctx.fillText(Math.round(val), padding - 12, y);
            
            // Garis Penanda (Tick Marks)
            ctx.beginPath();
            ctx.moveTo(padding - 6, y);
            ctx.lineTo(padding, y);
            ctx.strokeStyle = '#b2bec3';
            ctx.lineWidth = 1;
            ctx.stroke();
        }
    }

    drawContent() {
        const { ctx, width, height, padding, data, dataRaw } = this;
        const xLength = width - (padding * 2);
        const yLength = height - (padding * 2);
        const pointDistance = xLength / (data.length - 1);

        const coords = [];

        // Kalkulasi Koordinat Piksel
        dataRaw.forEach((item, index) => {
            const x = padding + (pointDistance * index);
            const y = (height - padding) - (item.jumlah / data.highest * yLength);
            coords.push({ x, y, val: item.jumlah, label: item.tanggal });
        });

        // --- 1. MENGGAMBAR GARIS GRAFIK (LINE) ---
        ctx.beginPath();
        ctx.strokeStyle = '#d63031'; // Merah
        ctx.lineWidth = 1;
        ctx.lineJoin = 'round';

        coords.forEach((pt, i) => {
            if (i === 0) ctx.moveTo(pt.x, pt.y);
            else ctx.lineTo(pt.x, pt.y);
        });
        ctx.stroke();

        // --- 2. MENGGAMBAR TITIK DAN LABEL DATA ---
        coords.forEach(pt => {
            // Lingkaran di setiap titik
            ctx.beginPath();
            ctx.fillStyle = '#d63031';
            ctx.arc(pt.x, pt.y, 5, 0, Math.PI * 2);
            ctx.fill();
            ctx.strokeStyle = '#ffffff';
            ctx.lineWidth = 2;
            ctx.stroke();

            // Label Nilai di atas titik
            ctx.fillStyle = '#2d3436';
            ctx.font = 'bold 11px Arial';
            ctx.textAlign = 'center';
            ctx.fillText(pt.val, pt.x, pt.y - 15);

            // Label Tanggal di sumbu X
            ctx.fillStyle = '#636e72';
            ctx.font = '11px Arial';
            ctx.fillText(pt.label, pt.x, height - padding + 20);
        });
    }
}

// Inisialisasi Grafik
const chart = new LineChart({
    canvasId: 'canvas',
    title: 'Statistik Perkembangan Kasus',
    data: [
        { tanggal: "01", jumlah: 13 },
        { tanggal: "02", jumlah: 20 },
        { tanggal: "03", jumlah: 70 },
        { tanggal: "04", jumlah: 10 },
        { tanggal: "05", jumlah: 60 },
        { tanggal: "06", jumlah: 25 },
        { tanggal: "07", jumlah: 50 },
        { tanggal: "08", jumlah: 30 }
    ]
});