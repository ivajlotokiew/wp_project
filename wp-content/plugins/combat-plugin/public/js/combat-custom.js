/**
 *
 * @param {Product} product
 * @returns {*}
 */
function productBadge(product) {
    let $mainWrap = jQuery('<div>', {'class': 'product-container', 'data-product_id': product.id});
    let $productWrap = jQuery('<div>', {'class': 'product-title', text: product.name});
    let $additionalInfoWrap = jQuery('<div>', {'class': 'additional-info'});
    let $productPrice = jQuery('<span>', {'class': 'product-price', text: product.price + 'Eur | '});
    let $categoryName = jQuery('<span>', {'class': 'product-category', text: product.category.name});

    $additionalInfoWrap.append($productPrice);
    $additionalInfoWrap.append($categoryName);
    $mainWrap.append($productWrap);
    $mainWrap.append($additionalInfoWrap);

    return $mainWrap;
}

class Product {

    constructor() {
        this.status = false;
    }

    get id() {
        return this._id;
    }

    set id(val) {
        if (val == null) {
            throw new Error("Id must be indicated");
        }

        this._id = val;
    }

    get name() {
        return this._name;
    }

    set name(val) {
        this._name = val;
    }

    get created() {
        return this._created;
    }

    set created(val) {
        this._created = val;
    }

    get description() {
        return this._description
    }

    set description(val) {
        this._description = val;
    }

    get price() {
        return this._price;
    }

    set price(val) {
        this._price = val;
    }

    get category() {
        return this._category;
    }

    set category(val) {
        if (!(val instanceof Category)) {
            return new Error("This is not category object!");
        }

        this._category = val;
    }

    get status() {
        return this._isEdited;
    }

    set status(val) {
        this._isEdited = val;
    }

    static getNameId() {
        return "id";
    }

    static getNameProduct() {
        return "name";
    }

    static getNameDescription() {
        return "description";
    }

    static getNameCreated() {
        return "created";
    }

    static getNamePrice() {
        return "price";
    }

    static getNameStatus() {
        return "status";
    }

    static bindProductObject(obj) {
        let product = new Product();

        product.category = Category.bindCategoryObject(obj);
        product.id = typeof obj[Product.getNameId()] !== undefined ? obj[Product.getNameId()] : null;
        product.name = typeof obj[Product.getNameProduct()] !== undefined ? obj[Product.getNameProduct()] : null;
        product.created = typeof obj[Product.getNameCreated()] !== undefined ? obj[Product.getNameCreated()] : null;
        product.description = typeof obj[Product.getNameDescription()] !== undefined ? obj[Product.getNameDescription()] : null;
        product.price = typeof obj[Product.getNamePrice()] !== undefined ? obj[Product.getNamePrice()] : null;

        return product;
    }

    edit() {
        let data = {};
        data.action = "edit_product";
        data.id = this._id;
        data.name = this._name;
        data.price = this._price;
        data.category_id = this._category.id;

        return jQuery.ajax({
            url: ajax_object.ajaxurl,
            type: 'POST',
            dataType: 'Json',
            data: data
        });
    }

    static getProduct(productId) {
        return jQuery.ajax({
            url: ajax_object.ajaxurl,
            type: 'POST',
            dataType: 'Json',
            data: {'action': 'get_product', 'id': productId}
        });
    }
}

class Category {
    get id() {
        return this._id;
    }

    set id(val) {
        if (val == null) {
            throw new Error("Id must be indicated");
        }

        this._id = val;
    }

    get name() {
        return this._name;
    }

    set name(val) {
        this._name = val;
    }

    static getNameId() {
        return "category_id";
    }

    static getNameCategory() {
        return "category_name"
    }

    static bindCategoryObject(obj) {
        let category = new Category();
        category.id = typeof obj[Category.getNameId()] !== undefined ? obj[Category.getNameId()] : null;
        category.name = typeof obj[Category.getNameCategory()] !== undefined ? obj[Category.getNameCategory()] : null;

        return category;
    }
}