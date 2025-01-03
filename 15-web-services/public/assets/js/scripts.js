$(document).ready(function () {

    //Cuando se selecciona una provincia: desbloquea todo y atocompleta municipios
    $('#provincia').change(function () {
        const provinciaSeleccionada = $(this).val()

        if (provinciaSeleccionada != "") {
            $.ajax({
                type: 'POST',
                url: 'index.php',
                data: {
                    provinciaSeleccionada: provinciaSeleccionada,
                    buscarMunicipio: true,
                },
                success: function (response) {

                    const municipios = document.getElementById("municipios")
                    municipios.innerHTML = ""
                    console.log(response)
                    const respuesta = JSON.parse(response)

                    respuesta.forEach(municipio => {
                        const option = document.createElement("option")
                        option.value = municipio
                        municipios.append(option)
                    })

                    document.getElementById("municipio").removeAttribute("readonly")
                    document.getElementById("numero").removeAttribute("readonly")
                    document.getElementById("tipoDeVia").removeAttribute("disabled")


                },
                error: function (error) {

                    console.error('Error durante la solicitud:', error)
                }
            })
        } else {
            document.getElementById("municipio").setAttribute("readonly", "")
            document.getElementById("numero").setAttribute("readonly", "")
            document.getElementById("tipoDeVia").setAttribute("disabled", "")
        }
    })

    //cuando se selecciona tipo de via: se vuelve a autocompletar, esta vez solo con ese tipo de via 
    $('#tipoDeVia, #municipio').change(function () {
        const provinciaSeleccionada = $('#provincia').val()
        const municipioSeleccionado = $('#municipio').val()
        const tipoDeViaSeleccionada = $("#tipoDeVia").val()

        document.getElementById("via").setAttribute("readonly", "")


        if (municipioSeleccionado != "" && tipoDeViaSeleccionada != "") {

            document.getElementById("resultado").innerHTML = "Cargando datos"

            const vias = document.getElementById("vias")
            vias.innerHTML = ""

            $.ajax({
                type: 'POST',
                url: 'index.php',
                data: {
                    provinciaSeleccionada: provinciaSeleccionada,
                    municipioSeleccionado: municipioSeleccionado,
                    tipoDeViaSeleccionada: tipoDeViaSeleccionada,
                    buscarVia: true
                },
                success: function (response) {
                    // console.log(response)

                    const respuesta = JSON.parse(response)

                    if (respuesta.err) {
                        console.log(response)
                        switch (respuesta.err) {
                            case 22:
                                generarTabla([["No se encontraron vias", "No existe el municipio " + municipioSeleccionado]], ["Problema", "Motivo"], null, null)
                                break;
                            case 10:
                                generarTabla([["No se encontraron vias", "No existe ese tipo de via en " + municipioSeleccionado]], ["Problema", "Motivo"], null, null)
                                break;

                            default:
                                break;
                        }

                    } else {
                        respuesta.forEach(via => {
                            const option = document.createElement("option")
                            option.value = via
                            vias.append(option)
                        })

                        document.getElementById("via").removeAttribute("readonly")
                        document.getElementById("resultado").innerHTML = ""

                    }


                },
                error: function (error) {
                    console.error('Error durante la solicitud:', error)
                }
            })
        }
    })

    //genera la tabla y la coloca en el id=resultado
    function generarTabla(data, titulosColumnas, columnaEnlaces, listaFunciones) {
        const contenedor = document.getElementById("resultado")
        contenedor.innerHTML = ""

        if (!columnaEnlaces || !listaFunciones || listaFunciones.length === 0) {
            columnaEnlaces = -1
        }

        const tabla = document.createElement("table")

        const encabezado = tabla.createTHead().insertRow()

        titulosColumnas.forEach(function (titulo) {
            const th = document.createElement("th")
            th.textContent = titulo
            encabezado.appendChild(th)
        })

        const cuerpoTabla = tabla.createTBody()

        data.forEach(function (filaData) {
            const fila = cuerpoTabla.insertRow()
            for (let i = 0; i < titulosColumnas.length; i++) {
                const celda = fila.insertCell()
                if (i === columnaEnlaces && columnaEnlaces !== -1) {
                    const enlace = document.createElement("a")
                    enlace.href = "#"
                    enlace.textContent = filaData[i]
                    enlace.addEventListener("click", listaFunciones.shift())
                    celda.appendChild(enlace)
                } else {
                    celda.textContent = filaData[i]
                }
            }
        })

        tabla.setAttribute("cellspacing", 0)
        tabla.setAttribute("cellpadding", 1)
        tabla.setAttribute("border", 1)

        contenedor.appendChild(tabla)
    }


    //cuando se envia el formulario: recoje el evento y pide al servidor la info
    $("#form").submit(function (event) {
        event.preventDefault()

        const provincia = $("#provincia").val()
        const municipio = $("#municipio").val()
        const tipoDeVia = $("#tipoDeVia").val()
        const via = $("#via").val()
        const numero = $("#numero").val() == "" ? 0 : $("#numero").val()


        if (provincia != "" || municipio != "" || tipoDeVia != "" || via != "") {

            const src = "https://www.google.com/maps?width=350&height=350&hl=es&q=" + encodeURIComponent(via + " " + numero + ", " + municipio + ", " + provincia) + "&t=k&z=18&ie=UTF8&iwloc=B&output=embed"
            $("#mapa").attr("src", src)
            document.getElementById("resultado").innerHTML = "Cargando datos"

            $.ajax({
                type: "POST",
                url: "index.php",
                data: {
                    provincia: provincia,
                    municipio: municipio,
                    tipoDeVia: tipoDeVia,
                    via: via,
                    numero: numero,
                    consultarFinca: true
                },
                success: function (response) {
                    console.log(response)
                    const tipoDeViaSeleccionada = $("#tipoDeVia option:selected").text()
                    const provinciaSeleccionada = $("#provincia option:selected").text()
                    const respuesta = JSON.parse(response)

                    if (respuesta.err) {
                        console.log(response)
                        switch (respuesta.err) {
                            case 33:
                                generarTabla([["No se encontraron Fincas", "No existe la calle en " + municipio]], ["Problema", "Motivo"], null, null)
                                break;
                            case 43:
                                datos = []
                                break;
                            default:
                                break;
                        }

                    } else {

                        let datos = respuesta.map(finca => {
                            return [finca.pnp + (finca.plp == " " || finca.plp == null ? "" : " " + finca.plp), finca.pc1 + finca.pc2]
                        })

                        //funciones hoja del catastro
                        let listaFunciones = respuesta.map(finca => {
                            return (

                                function () {
                                    document.getElementById("resultado").innerHTML = "Cargando datos"
                                    $.ajax({
                                        type: "POST",
                                        url: "index.php",
                                        data: {
                                            provincia: provincia,
                                            municipio: municipio,
                                            referenciaCatastral: finca.pc1 + finca.pc2,
                                            numero: finca.pnp,
                                            consultarHojaDelCatastro: true
                                        },
                                        success: function (response) {

                                            console.log(response)

                                            const respuesta = JSON.parse(response)
                                            const listaFunciones = []
                                            const datos = respuesta.map(inmueble => {
                                                listaFunciones.push(() => {
                                                    document.getElementById("resultado").innerHTML = "Cargando datos"

                                                    $.ajax({
                                                        type: "POST",
                                                        url: "index.php",
                                                        data: {
                                                            provincia: provincia,
                                                            municipio: municipio,
                                                            referenciaCatastral: inmueble.pc1 + inmueble.pc2 + inmueble.car + inmueble.cc1 + inmueble.cc2,
                                                            numero: numero,
                                                            consultarInmueble: true
                                                        },
                                                        success: function (response) {
                                                            console.log(response)
                                                            const inmueble = JSON.parse(response)
                                                            const datos = [
                                                                ["Referencia Catastral", inmueble.ref],
                                                                ["Localización", inmueble.ldt],
                                                                ["Clase", inmueble.cn],
                                                                ["Uso", inmueble.luso],
                                                                ["Superficie Construida", inmueble.sfc],
                                                                ["Año construido", inmueble.ant],
                                                                ["Precio Estimado", inmueble.precio.toLocaleString('es-ES', { style: 'currency', currency: 'EUR', minimumFractionDigits: 0 })]
                                                            ]

                                                            generarTabla(datos, ["Categoria", "Datos decriptibles del inmueble"], null, null)

                                                        },
                                                        error: function (error) {
                                                            console.error("Error durante la solicitud:", error)
                                                        }
                                                    })
                                                })
                                                return [inmueble.nv, inmueble.pnp, inmueble.es, inmueble.pt, inmueble.pu, inmueble.pc1 + inmueble.pc2 + inmueble.car + inmueble.cc1 + inmueble.cc2]

                                            })

                                            generarTabla(datos, ["Vía", "Número", "Escalera", "Planta", "Puerta", "Referencia catastral"], 5, listaFunciones)

                                        },
                                        error: function (error) {
                                            console.error("Error durante la solicitud:", error)
                                        }
                                    })
                                }
                            )
                        })

                        if (numero == 0 && datos.length != 1) {
                            datos = [["ELIGE UN NUMERO", ""], ...datos]
                            listaFunciones = [() => { }, ...listaFunciones]
                        } else if (datos.length != 1) {
                            datos = [["EL NUMERO " + numero + " NO EXISTE", ""], ...datos]
                            listaFunciones = [() => { }, ...listaFunciones]
                        }

                        generarTabla(datos, ["Número", "Hoja del catastro"], 1, listaFunciones)
                    }
                },
                error: function (error) {
                    console.error("Error durante la solicitud:", error)
                }
            })
        }

    })

})
