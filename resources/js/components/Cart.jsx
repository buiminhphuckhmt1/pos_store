import React, { Component } from "react";
import ReactDOM from "react-dom";
import axios from "axios";
import Swal from "sweetalert2";
import { sum } from "lodash";

class Cart extends Component {
    constructor(props) {
        super(props);
        this.state = {
            cart: [],
            products: [],
            customers: [],
            barcode: "",
            discount: "0",
            search: "",
            customer_id: "",
        };

        this.loadCart = this.loadCart.bind(this);
        this.handleOnChangeBarcode = this.handleOnChangeBarcode.bind(this);
        this.handleScanBarcode = this.handleScanBarcode.bind(this);
        this.handleOnChangeDisscount = this.handleOnChangeDisscount.bind(this);
        this.handleChangeQty = this.handleChangeQty.bind(this);
        this.handleEmptyCart = this.handleEmptyCart.bind(this);

        this.loadProducts = this.loadProducts.bind(this);
        this.handleChangeSearch = this.handleChangeSearch.bind(this);
        this.handleSeach = this.handleSeach.bind(this);
        this.setCustomerId = this.setCustomerId.bind(this);
        this.handleClickSubmit = this.handleClickSubmit.bind(this);
        this.handleClickadd = this.handleClickadd.bind(this);
    }

    componentDidMount() {
        // load user cart
        this.loadCart();
        this.loadProducts();
        this.loadCustomers();
    }

    loadCustomers() {
        axios.get(`/admin/customers`).then((res) => {
            const customers = res.data;
            this.setState({ customers });
        });
    }

    loadProducts(search = "") {
        const query = !!search ? `?search=${search}` : "";
        axios.get(`/admin/products${query}`).then((res) => {
            const products = res.data.data;
            this.setState({ products });
        });
    }

    handleOnChangeBarcode(event) {
        const barcode = event.target.value;
        console.log(barcode);
        this.setState({ barcode });
    }

    loadCart() {
        axios.get("/admin/cart").then((res) => {
            const cart = res.data;
            this.setState({ cart });
        });
    }

    handleScanBarcode(event) {
        event.preventDefault();
        const { barcode } = this.state;
        if (!!barcode) {
            axios
                .post("/admin/cart", { barcode })
                .then((res) => {
                    this.loadCart();
                    this.setState({ barcode: "" });
                })
                .catch((err) => {
                    Swal.fire("Lỗi!", err.response.data.message, "error");
                });
        }
    }
    handleChangeQty(product_id, qty) {
        const cart = this.state.cart.map((c) => {
            if (c.id === product_id) {
                c.pivot.quantity = qty;
            }
            return c;
        });

        this.setState({ cart });
        if (!qty) return;

        axios
            .post("/admin/cart/change-qty", { product_id, quantity: qty })
            .then((res) => {})
            .catch((err) => {
                Swal.fire("Error!", err.response.data.message, "error");
            });
    }
    handleOnChangeDisscount(event) {
        const discount = event.target.value;
        console.log(discount);
        return discount;
    }
    getTotal(cart) {
        const total = cart.map((c) => c.pivot.quantity * c.outputprice);
        return sum(total);
    }
    handleClickDelete(product_id) {
        axios
            .post("/admin/cart/delete", { product_id, _method: "DELETE" })
            .then((res) => {
                const cart = this.state.cart.filter((c) => c.id !== product_id);
                this.setState({ cart });
            });
    }
    handleEmptyCart() {
        axios.post("/admin/cart/empty", { _method: "DELETE" }).then((res) => {
            this.setState({ cart: [] });
        });
    }
    handleChangeSearch(event) {
        const search = event.target.value;
        this.setState({ search });
    }
    handleSeach(event) {
        if (event.keyCode === 13) {
            this.loadProducts(event.target.value);
        }
    }

    addProductToCart(barcode) {
        let product = this.state.products.find((p) => p.barcode === barcode);
        if (!!product) {
            // if product is already in cart
            let cart = this.state.cart.find((c) => c.id === product.id);
            if (!!cart) {
                // update quantity
                this.setState({
                    cart: this.state.cart.map((c) => {
                        if (
                            c.id === product.id &&
                            product.quantity > c.pivot.quantity
                        ) {
                            c.pivot.quantity = c.pivot.quantity + 1;
                        }
                        return c;
                    }),
                });
            } else {
                if (product.quantity > 0) {
                    product = {
                        ...product,
                        pivot: {
                            quantity: 1,
                            product_id: product.id,
                            user_id: 1,
                        },
                    };

                    this.setState({ cart: [...this.state.cart, product] });
                }
            }

            axios
                .post("/admin/cart", { barcode })
                .then((res) => {
                    // this.loadCart();
                    console.log(res);
                })
                .catch((err) => {
                    Swal.fire("Error!", err.response.data.message, "error");
                });
        }
    }

    setCustomerId(event) {
        this.setState({ customer_id: event.target.value });
    }
    handleClickSubmit() {
        Swal.fire({
            title: "Tạo Hóa đơn",
            html:'<p>Số tiền nhận được</p>',
            input: "text",
            inputValue: this.getTotal(this.state.cart),
            showCancelButton: true,
            cancelButtonText: "Hủy",
            confirmButtonText: "Tạo",
            showLoaderOnConfirm: true,
            preConfirm: (amount) => {
                return axios
                    .post("/admin/orders", {
                        customer_id: this.state.customer_id,
                        amount,
                    })
                    .then((res) => {
                        this.loadCart();
                        return res.data;
                    })
                    .catch((err) => {
                        Swal.showValidationMessage(err.response.data.message);
                    });
            },
            allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
            if (result.value) {
                //
            }
        });
    }
    handleClickadd() {
        Swal.fire({
            title: "Tạo Khách hàng mới",
            html:'<p>Họ Và Tên:</p>'+'<input id="swal-input1" class="swal2-input">' +
                 '<p>Số Điện Thoại:</p>'+'<input id="swal-input2" class="swal2-input">' +
                 '<p>Địa chỉ:</p>'+'<input id="swal-input3" class="swal2-input">',
            showCancelButton: true,
            cancelButtonText: "Hủy",
            confirmButtonText: "Tạo",
            showLoaderOnConfirm: true,
            preConfirm: function () {
                return new Promise(function (resolve) {
                    resolve([
                      $('#swal-input1').val(),
                      $('#swal-input2').val(),
                      $('#swal-input3').val()
                    ])
                  })
                    .catch((err) => {
                        Swal.showValidationMessage(err.response.data.message);
                    });
            },
            allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
            if (result.value) {
                //
            }
        });
    }
    render() {
        const { cart, products, customers, barcode } = this.state;
        return (
            <div className="row">
                <div className="col-md-6 col-lg-4">
                    <div className="row mb-2">
                        <div className="col">
                            <form onSubmit={this.handleScanBarcode}>
                                <input
                                    type="text"
                                    className="form-control"
                                    placeholder="Quét mã vạch..."
                                    value={barcode}
                                    onChange={this.handleOnChangeBarcode}
                                />
                            </form>
                        </div>
                        <div className="col d-flex ">
                            <select
                                className="form-control"
                                onChange={this.setCustomerId}
                            >
                                <option value="">Khách vãng lai</option>
                                {customers.map((cus) => (
                                    <option
                                        key={cus.id}
                                        value={cus.id}
                                    >{`${cus.last_name}`}</option>
                                ))}
                            </select>
                            <div class="input-group-append">
                                <button 
                                type="button" 
                                class="btn btn-primary"
                                disabled={!cart.length}
                                onClick={this.handleClickadd}
                                >
                                    <span><i class='bx bx-user-plus'></i></span>
                                </button>
                            </div>
                        </div>

                    </div>
                    <div className="user-cart mb-1">
                        <div className="card vh-42 overflow-auto">
                            <table className="table table-striped ">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Đơn vị tính</th>
                                        <th>Số lượng</th>
                                        <th className="text-right">Giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {cart.map((c) => (
                                        <tr key={c.id}>
                                            <td class="overflow-hidden">{c.name}</td>
                                            <td>{c.description}</td>
                                            <td class="">
                                                <div class="d-inline-flex">
                                                <input
                                                    type="text"
                                                    className="form-control form-control-sm qty"
                                                    value={c.pivot.quantity}
                                                    onChange={(event) =>
                                                        this.handleChangeQty(
                                                            c.id,
                                                            event.target.value
                                                        )
                                                    }
                                                />
                                                <button
                                                    className="btn btn-danger p-1"
                                                    onClick={() =>
                                                        this.handleClickDelete(
                                                            c.id
                                                        )
                                                    }
                                                >
                                                    <i class="bx bx-trash "></i>
                                                </button>
                                                </div>
                                            </td>
                                            <td className="text-right">
                                                
                                                {(
                                                    c.outputprice * c.pivot.quantity
                                                )}{window.APP.currency_symbol}
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div className="row d-flex mb-1">
                        <div className="col">Tổng tiền:</div>
                        <div className="col d-flex align-items-center justify-content-end">
                             {this.getTotal(cart)} {window.APP.currency_symbol}
                        </div>
                    </div>
                    <div className="row d-flex mb-1">
                        <div className="col">Giảm giá:</div>
                        <div className="col d-flex align-items-center justify-content-end">
                                <input
                                    type="text"
                                    className="form-control"
                                    placeholder="Giảm giá"
                                   
                                    onChange={this.handleOnChangeDisscount}
                                />
                        </div>
                    </div>
                    <div className="row d-flex mb-1">
                        <div className="col">Thành tiền:</div>
                        <div className="col d-flex align-items-center justify-content-end">
                             {this.getTotal(cart)} {window.APP.currency_symbol}
                        </div>
                    </div>
                    <div className="row mt-3">
                        <div className="col ">
                            <button
                                type="button"
                                className="btn btn-danger btn-block"
                                onClick={this.handleEmptyCart}
                                disabled={!cart.length}
                            >
                                Hủy
                            </button>
                        </div>
                        <div className="col d-flex align-items-center justify-content-end">
                            <button
                                type="button"
                                className="btn btn-primary btn-block"
                                disabled={!cart.length}
                                onClick={this.handleClickSubmit}
                            >
                                Tạo hóa đơn
                            </button>
                        </div>
                    </div>
                </div>
                <div className="col-md-6 col-lg-8">
                    <div className="mb-2">
                        <input
                            type="text"
                            className="form-control"
                            placeholder="Search Product..."
                            onChange={this.handleChangeSearch}
                            onKeyDown={this.handleSeach}
                        />
                    </div>
                    <div className="order-product">
                        <div className="row">
                           
                        <div class="col-md-12 d-flex flex-row flex-wrap bd-highlight list-item mt-2 overflow-auto vh-100">
                            {products.map((p) => (
                                <div class="col-xl-2 col-md-4 col-6 p-1">
                            <div onClick={() => this.addProductToCart(p.barcode)}
                            key={p.id} class="card overflow-hidden bd-highlight">
                                <div class="list-thumb d-flex  justify-content-center">
                                    <img src={p.image_url} height="100px" width="100%"/>
                                </div> 
                                <div class="flex-grow-1 d-bock">
                                    <div class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center">
                                        <div class="w-40 w-sm-100 item-title ct-inline">{p.name}</div> 
                                        <p class="text-muted text-black-50 w-15 w-sm-100 mb-1">{p.barcode}</p>
                                        <span class=" w-sm-100">{p.outputprice}{window.APP.currency_symbol}</span>  
                                        <p class="position-absolute m-0 text-muted text-small w-15 w-sm-100 d-none d-lg-block item-badges top-1 right-1" >
                                            <span class="badge bg-label-primary me-1">{p.quantity} {p.description}</span>
                                        </p>                                    
                                    </div>
                                </div>
                                </div>
                            </div>
                            ))}
                        </div>
                        </div>
                    </div>
                </div> 
            </div>
        );
    }
}

export default Cart;

if (document.getElementById("cart")) {
    ReactDOM.render(<Cart />, document.getElementById("cart"));
}

