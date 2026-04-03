class Admin:
    def __init__(self, id_admin, nama_admin, email, password, created_at):
        self.id_admin = id_admin
        self.nama_admin = nama_admin
        self.email = email
        self.password = password
        self.created_at = created_at

    def login(self, email, password):
        pass

    def logout(self):
        pass

    def changePassword(self, old_pw, new_pw):
        pass

    def hashPassword(self, password):
        pass

    def getProfile(self):
        pass


class Klien:
    def __init__(self, id_klien, nama_klien, email_klien, telepon, alamat, created_at):
        self.id_klien = id_klien
        self.nama_klien = nama_klien
        self.email_klien = email_klien
        self.telepon = telepon
        self.alamat = alamat
        self.created_at = created_at

    def save(self):
        pass

    def update(self):
        pass

    def delete(self):
        pass

    def findById(self, id):
        pass

    def getInvoices(self):
        pass


class Produk:
    def __init__(self, id_produk, kode_produk, nama_produk, satuan, harga_satuan, stock_min, stock, created_at):
        self.id_produk = id_produk
        self.kode_produk = kode_produk
        self.nama_produk = nama_produk
        self.satuan = satuan
        self.harga_satuan = harga_satuan
        self.stock_min = stock_min
        self.stock = stock
        self.created_at = created_at

    def save(self):
        pass

    def update(self):
        pass

    def delete(self):
        pass

    def isStockLow(self):
        pass

    def updateStock(self, qty):
        pass


class Invoice:
    def __init__(self, id_invoice, no_invoice, id_klien, id_admin, tanggal_buat, tanggal_jatuh_tempo, total, status, created_at):
        self.id_invoice = id_invoice
        self.no_invoice = no_invoice
        self.id_klien = id_klien
        self.id_admin = id_admin
        self.tanggal_buat = tanggal_buat
        self.tanggal_jatuh_tempo = tanggal_jatuh_tempo
        self.total = total
        self.status = status
        self.created_at = created_at

    def save(self):
        pass

    def update(self):
        pass

    def delete(self):
        pass

    def send(self):
        pass

    def calculateTotal(self):
        pass

    def checkOverdue(self):
        pass

    def generateNoInvoice(self):
        pass

    def getDetail(self):
        pass


class InvoiceDetail:
    def __init__(self, id_detail, id_invoice, id_produk, quantity, harga_jual_saat_ini, subtotal):
        self.id_detail = id_detail
        self.id_invoice = id_invoice
        self.id_produk = id_produk
        self.quantity = quantity
        self.harga_jual_saat_ini = harga_jual_saat_ini
        self.subtotal = subtotal

    def save(self):
        pass

    def delete(self):
        pass

    def calculateSubtotal(self):
        pass


class Pembayaran:
    def __init__(self, id_pembayaran, id_invoice, id_admin, tanggal_bayar, jumlah_bayar, metode_bayar, bukti_transfer, status_verifikasi, catatan, created_at):
        self.id_pembayaran = id_pembayaran
        self.id_invoice = id_invoice
        self.id_admin = id_admin
        self.tanggal_bayar = tanggal_bayar
        self.jumlah_bayar = jumlah_bayar
        self.metode_bayar = metode_bayar
        self.bukti_transfer = bukti_transfer
        self.status_verifikasi = status_verifikasi
        self.catatan = catatan
        self.created_at = created_at

    def save(self):
        pass

    def verify(self):
        pass

    def reject(self, catatan):
        pass

    def uploadBukti(self, file):
        pass