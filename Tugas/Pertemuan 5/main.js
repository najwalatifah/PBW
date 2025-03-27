document.getElementById("cekNilaiBtn").addEventListener("click", function() {
    let nim = document.getElementById("nim").value;
    let nilai = parseFloat(document.getElementById("nilai").value);
    let output = document.getElementById("output");

    if (!nim) {
        output.innerHTML = "<span style='color: red;'>NIM tidak boleh kosong!</span>";
        return;
    }

    if (isNaN(nilai) || nilai < 0 || nilai > 100) {
        output.innerHTML = "<span style='color: red;'>Nilai tidak valid!</span>";
        return;
    }

    let hurufMutu;
    if (nilai >= 80) hurufMutu = "A";
    else if (nilai >= 70) hurufMutu = "B";
    else if (nilai >= 60) hurufMutu = "C";
    else if (nilai >= 50) hurufMutu = "D";
    else hurufMutu = "E";

    output.innerHTML = `NIM: ${nim} <br> Huruf Mutu: ${hurufMutu}`;
});
