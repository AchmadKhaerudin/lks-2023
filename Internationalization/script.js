  /**
         * Fungsi i18n untuk menangani JSON Eksternal & Nested Keys
         * Berdasarkan Modul C5 Speedtest
         */
        async function changeLanguage(lang) {
            try {
                const response = await fetch(`./${lang}.json`);
                if (!response.ok) throw new Error("File JSON tidak ditemukan");
                
                const data = await response.json();

                // Simpan preferensi pengguna
                localStorage.setItem("userLang", lang);
                document.getElementById("lang-select").value = lang;

                // Update teks pada elemen yang memiliki atribut data-i18n
                document.querySelectorAll("[data-i18n]").forEach(el => {
                    const keyPath = el.getAttribute("data-i18n").split("."); // Misal: "nav.home"
                    
                    // Navigasi ke dalam objek JSON (Nested resolution)
                    let text = data;
                    keyPath.forEach(key => {
                        if (text) text = text[key];
                    });

                    if (text) el.textContent = text;
                });
            } catch (err) {
                console.error("Gagal memproses bahasa:", err);
            }
        }

        // Inisialisasi awal saat halaman dimuat
        document.addEventListener("DOMContentLoaded", () => {
            const savedLang = localStorage.getItem("userLang") || "en";
            changeLanguage(savedLang);
        });