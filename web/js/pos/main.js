function setPrice(value) {
    $('#product-unit_price-disp').inputmask("setvalue", value);
    $('#orderproduct-unit_price-disp').inputmask("setvalue", value);
    $('#orderproduct-unit_price-disp').focus();
}