import heapq
from datetime import datetime, timedelta
import timeit
import matplotlib.pyplot as plt  

class PenjadwalanTugas:
    def __init__(self):
        self.tugas_iteratif = []  
        self.tugas_rekursif = [] 

    def tambah_tugas_iteratif(self, nama, tanggal, waktu, prioritas):
        try:
            deadline_str = f"{tanggal} {waktu}"
            deadline_dt = datetime.strptime(deadline_str, '%Y-%m-%d %H:%M')
            heapq.heappush(self.tugas_iteratif, (prioritas, deadline_dt, nama))
            return f"Tugas '{nama}' berhasil ditambahkan menggunakan metode iteratif."
        except ValueError:
            return "Format tanggal atau waktu salah! Gunakan format: YYYY-MM-DD untuk tanggal dan HH:MM untuk waktu."

    def tambah_tugas_rekursif(self, nama, tanggal, waktu, prioritas, tugas=None):
        if tugas is None:
            tugas = self.tugas_rekursif
        try:
            deadline_str = f"{tanggal} {waktu}"
            deadline_dt = datetime.strptime(deadline_str, '%Y-%m-%d %H:%M')
            tugas.append((prioritas, deadline_dt, nama))
            tugas.sort(key=lambda x: x[0])  # Sorting manual untuk rekursif
            return f"Tugas '{nama}' berhasil ditambahkan menggunakan metode rekursif."
        except ValueError:
            return "Format tanggal atau waktu salah! Gunakan format: YYYY-MM-DD untuk tanggal dan HH:MM untuk waktu."

    def tampilkan_semua_tugas_iteratif(self):
        if not self.tugas_iteratif:
            return "Tidak ada tugas yang terdaftar."
        semua_tugas = []
        for t in self.tugas_iteratif:
            semua_tugas.append(f"{t[2]} (Deadline: {t[1].strftime('%Y-%m-%d %H:%M')}, Prioritas: {t[0]})")
        return semua_tugas

    def tampilkan_semua_tugas_rekursif(self, tugas=None, index=0):
        if tugas is None:
            tugas = self.tugas_rekursif
        if index == len(tugas):
            return "Tidak ada tugas yang terdaftar."
        t = tugas[index]
        tugas_str = f"{t[2]} (Deadline: {t[1].strftime('%Y-%m-%d %H:%M')}, Prioritas: {t[0]})"
        return [tugas_str] + self.tampilkan_semua_tugas_rekursif(tugas, index + 1)

    def tugas_selesai(self, nama_tugas):
        for i, t in enumerate(self.tugas_iteratif):
            if t[2] == nama_tugas:
                self.tugas_iteratif.pop(i)
                heapq.heapify(self.tugas_iteratif)
                return f"Tugas '{nama_tugas}' selesai dan dihapus."
        for i, t in enumerate(self.tugas_rekursif):
            if t[2] == nama_tugas:
                self.tugas_rekursif.pop(i)
                return f"Tugas '{nama_tugas}' selesai dan dihapus."
        return f"Tugas '{nama_tugas}' tidak ditemukan."

def bandingkan_waktu_dengan_plot(range_n):
    iteratif_times = []
    rekursif_times = []

    for n in range_n:
        penjadwal = PenjadwalanTugas()
        for i in range(1, n + 1):
            penjadwal.tambah_tugas_iteratif(f"Tugas {i}", "2024-12-22", "12:00", i)
            penjadwal.tambah_tugas_rekursif(f"Tugas {i}", "2024-12-22", "12:00", i)
        
        waktu_iteratif = timeit.timeit(lambda: penjadwal.tampilkan_semua_tugas_iteratif(), number=100)
        waktu_rekursif = timeit.timeit(lambda: penjadwal.tampilkan_semua_tugas_rekursif(), number=100)

        iteratif_times.append(waktu_iteratif)
        rekursif_times.append(waktu_rekursif)

    # Plot grafik
    plt.figure(figsize=(10, 6))
    plt.plot(range_n, iteratif_times, label="Iteratif", marker='o')
    plt.plot(range_n, rekursif_times, label="Rekursif", marker='o')
    plt.xlabel("Jumlah Tugas (n)")
    plt.ylabel("Waktu Eksekusi (detik)")
    plt.title("Perbandingan Waktu Iteratif vs Rekursif")
    plt.legend()
    plt.grid(True)
    plt.show()

    print("\n+-----+-----------------------+-----------------------+")
    print("|  n  | Recursive Time (s)   | Iterative Time (s)   |")
    print("+-----+-----------------------+-----------------------+")
    for n, waktu_r, waktu_i in zip(range_n, rekursif_times, iteratif_times):
        print(f"| {n:<3} | {waktu_r:<21.6f} | {waktu_i:<21.6f} |")
    print("+-----+-----------------------+-----------------------+")

def main():
    penjadwal = PenjadwalanTugas()
    while True:
        print("\n==== Menu Penjadwalan Tugas ====")
        print("1. Tambah Tugas")
        print("2. Lihat Semua Tugas")
        print("3. Tandai Tugas Selesai")
        print("4. Bandingkan Waktu Iteratif vs Rekursif (dengan Grafik)")
        print("5. Keluar")
        pilihan = input("Masukkan pilihan (1-5): ")

        if pilihan == '1':
            nama = input("Masukkan nama tugas: ")
            tanggal = input("Masukkan tanggal (YYYY-MM-DD): ")
            waktu = input("Masukkan waktu (HH:MM): ")
            try:
                prioritas = int(input("Masukkan prioritas (angka lebih kecil = lebih tinggi): "))
                print("\nPilih metode untuk menambahkan tugas:")
                print("1. Iteratif")
                print("2. Rekursif")
                metode = input("Pilih metode (1 atau 2): ")
                if metode == '1':
                    pesan = penjadwal.tambah_tugas_iteratif(nama, tanggal, waktu, prioritas)
                    print(pesan)
                elif metode == '2':
                    pesan = penjadwal.tambah_tugas_rekursif(nama, tanggal, waktu, prioritas)
                    print(pesan)
                else:
                    print("Pilihan metode tidak valid.")
            except ValueError:
                print("Prioritas harus berupa angka!")

        elif pilihan == '2':
            print("\n==== Lihat Semua Tugas ====")
            print("1. Gunakan metode Iteratif")
            print("2. Gunakan metode Rekursif")
            metode = input("Pilih metode (1 atau 2): ")
            if metode == '1':
                print("\nHasil (Iteratif):")
                semua_tugas_iteratif = penjadwal.tampilkan_semua_tugas_iteratif()
                if isinstance(semua_tugas_iteratif, str):
                    print(semua_tugas_iteratif)
                else:
                    for t in semua_tugas_iteratif:
                        print(t)
            elif metode == '2':
                print("\nHasil (Rekursif):")
                semua_tugas_rekursif = penjadwal.tampilkan_semua_tugas_rekursif()
                if isinstance(semua_tugas_rekursif, str):
                    print(semua_tugas_rekursif)
                else:
                    for t in semua_tugas_rekursif:
                        print(t)
            else:
                print("Pilihan metode tidak valid.")
        elif pilihan == '3':
            nama_tugas = input("Masukkan nama tugas yang selesai: ")
            pesan = penjadwal.tugas_selesai(nama_tugas)
            print(pesan)
        elif pilihan == '4':
            try:
                n_awal = int(input("Masukkan nilai awal n: "))
                n_akhir = int(input("Masukkan nilai akhir n: "))
                langkah = int(input("Masukkan langkah n: "))
                if n_awal > n_akhir or langkah <= 0:
                    print("Input tidak valid. Pastikan n_awal < n_akhir dan langkah > 0.")
                else:
                    range_n = list(range(n_awal, n_akhir + 1, langkah))
                    bandingkan_waktu_dengan_plot(range_n)
            except ValueError:
                print("Input harus berupa angka.")
        elif pilihan == '5':
            print("Keluar dari program. Selamat bekerja!")
            break
        else:
            print("Pilihan tidak valid. Silakan coba lagi.")

if __name__ == "__main__":
    main()
    