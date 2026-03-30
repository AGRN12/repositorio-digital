# -*- coding: utf-8 -*-
import tkinter as tk
from tkinter import messagebox
import json
import os

class Inventario:
    def __init__(self, archivo='inventario.json'):
        self.productos = {}
        self.archivo = archivo
        self.cargar_datos()

    def registrar_producto(self, codigo, nombre, cantidad, precio):
        if codigo in self.productos:
            raise ValueError("El producto con este código ya existe.")
        self.productos[codigo] = {
            'nombre': nombre,
            'cantidad': cantidad,
            'precio': precio
        }
        self.guardar_datos()

    def actualizar_cantidad(self, codigo, nueva_cantidad):
        if codigo not in self.productos:
            raise KeyError("El producto no existe.")
        self.productos[codigo]['cantidad'] = nueva_cantidad
        self.guardar_datos()

    def eliminar_producto(self, codigo):
        if codigo not in self.productos:
            raise KeyError("El producto no existe.")
        del self.productos[codigo]
        self.guardar_datos()

    def consultar_cantidad(self, codigo):
        if codigo not in self.productos:
            raise KeyError("El producto no existe.")
        return self.productos[codigo]['cantidad']

    def consultar_productos_mayor_cantidad(self, cantidad_minima):
        return {codigo: info for codigo, info in self.productos.items() if info['cantidad'] > cantidad_minima}

    def obtener_todos_productos(self):
        return self.productos

    def guardar_datos(self):
        with open(self.archivo, 'w') as f:
            json.dump(self.productos, f, indent=4)

    def cargar_datos(self):
        if os.path.exists(self.archivo):
            with open(self.archivo, 'r') as f:
                self.productos = json.load(f)

class Aplicacion(tk.Tk):
    def __init__(self):
        super().__init__()
        self.inventario = Inventario()
        self.title("Sistema de Gestión de Inventarios")
        self.geometry("600x500")
        # Widgets
        self.create_widgets()

    def create_widgets(self):
        # Labels and Entries
        tk.Label(self, text="Código").grid(row=0, column=0, padx=10, pady=10)
        tk.Label(self, text="Nombre").grid(row=1, column=0, padx=10, pady=10)
        tk.Label(self, text="Cantidad").grid(row=2, column=0, padx=10, pady=10)
        tk.Label(self, text="Precio").grid(row=3, column=0, padx=10, pady=10)
        self.codigo_entry = tk.Entry(self)
        self.nombre_entry = tk.Entry(self)
        self.cantidad_entry = tk.Entry(self)
        self.precio_entry = tk.Entry(self)
        self.codigo_entry.grid(row=0, column=1, padx=10, pady=10)
        self.nombre_entry.grid(row=1, column=1, padx=10, pady=10)
        self.cantidad_entry.grid(row=2, column=1, padx=10, pady=10)
        self.precio_entry.grid(row=3, column=1, padx=10, pady=10)
        # Buttons
        tk.Button(self, text="Registrar Producto", command=self.registrar_producto).grid(row=4, column=0, padx=10, pady=10)
        tk.Button(self, text="Actualizar Cantidad", command=self.actualizar_cantidad).grid(row=4, column=1, padx=10, pady=10)
        tk.Button(self, text="Eliminar Producto", command=self.eliminar_producto).grid(row=5, column=0, padx=10, pady=10)
        tk.Button(self, text="Consultar Cantidad", command=self.consultar_cantidad).grid(row=5, column=1, padx=10, pady=10)
        tk.Button(self, text="Consultar > Cantidad", command=self.consultar_productos_mayor_cantidad).grid(row=6, column=0, padx=10, pady=10)
        tk.Button(self, text="Ver Todos los Productos", command=self.ver_todos_productos).grid(row=6, column=1, padx=10, pady=10)
        # Text widget for output
        self.output_text = tk.Text(self, height=15, width=70)
        self.output_text.grid(row=7, column=0, columnspan=2, padx=10, pady=10)

    def registrar_producto(self):
        try:
            codigo = self.codigo_entry.get()
            nombre = self.nombre_entry.get()
            cantidad = int(self.cantidad_entry.get())
            precio = float(self.precio_entry.get())
            self.inventario.registrar_producto(codigo, nombre, cantidad, precio)
            messagebox.showinfo("Éxito", "Producto registrado exitosamente.")
            self.limpiar_entradas()
        except ValueError as e:
            messagebox.showerror("Error", str(e))

    def actualizar_cantidad(self):
        try:
            codigo = self.codigo_entry.get()
            nueva_cantidad = int(self.cantidad_entry.get())
            self.inventario.actualizar_cantidad(codigo, nueva_cantidad)
            messagebox.showinfo("Éxito", "Cantidad actualizada exitosamente.")
            self.limpiar_entradas()
        except KeyError as e:
            messagebox.showerror("Error", str(e))
        except ValueError:
            messagebox.showerror("Error", "Cantidad debe ser un número entero.")

    def eliminar_producto(self):
        try:
            codigo = self.codigo_entry.get()
            self.inventario.eliminar_producto(codigo)
            messagebox.showinfo("Éxito", "Producto eliminado exitosamente.")
            self.limpiar_entradas()
        except KeyError as e:
            messagebox.showerror("Error", str(e))

    def consultar_cantidad(self):
        try:
            codigo = self.codigo_entry.get()
            cantidad = self.inventario.consultar_cantidad(codigo)
            self.output_text.delete(1.0, tk.END)
            self.output_text.insert(tk.END, f"Cantidad de producto '{codigo}': {cantidad}\n")
        except KeyError as e:
            messagebox.showerror("Error", str(e))

    def consultar_productos_mayor_cantidad(self):
        try:
            cantidad_minima = int(self.cantidad_entry.get())
            productos = self.inventario.consultar_productos_mayor_cantidad(cantidad_minima)
            self.output_text.delete(1.0, tk.END)
            if productos:
                for codigo, info in productos.items():
                    self.output_text.insert(tk.END, f"Codigo: {codigo}, Nombre: {info['nombre']}, Cantidad: {info['cantidad']}, Precio: {info['precio']}\n")
            else:
                self.output_text.insert(tk.END, "No hay productos con cantidad mayor a la especificada.\n")
        except ValueError:
            messagebox.showerror("Error", "Cantidad mínima debe ser un número entero.")

    def ver_todos_productos(self):
        productos = self.inventario.obtener_todos_productos()
        self.output_text.delete(1.0, tk.END)
        if productos:
            for codigo, info in productos.items():
                self.output_text.insert(tk.END, f"Codigo: {codigo}, Nombre: {info['nombre']}, Cantidad: {info['cantidad']}, Precio: {info['precio']}\n")
        else:
            self.output_text.insert(tk.END, "No hay productos en el inventario.\n")

    def limpiar_entradas(self):
        self.codigo_entry.delete(0, tk.END)
        self.nombre_entry.delete(0, tk.END)
        self.cantidad_entry.delete(0, tk.END)
        self.precio_entry.delete(0, tk.END)

if __name__ == "__main__":
    app = Aplicacion()
    app.mainloop()
