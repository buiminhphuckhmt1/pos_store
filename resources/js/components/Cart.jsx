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
            discount: 0,
            search: "",
            customer_id: "",
            total: 0,
            totalBill: 0
        };

        this.loadCart = this.loadCart.bind(this);
        this.handleOnChangeBarcode = this.handleOnChangeBarcode.bind(this);
        this.handleScanBarcode = this.handleScanBarcode.bind(this);
        this.handleClickadd = this.handleClickadd.bind(this);
        this.handleOnChangeDisscount = this.handleOnChangeDisscount.bind(this);
        this.handleChangeQty = this.handleChangeQty.bind(this);
        this.handleEmptyCart = this.handleEmptyCart.bind(this);

        this.loadProducts = this.loadProducts.bind(this);
        this.handleChangeSearch = this.handleChangeSearch.bind(this);
        this.handleSeach = this.handleSeach.bind(this);
        this.setCustomerId = this.setCustomerId.bind(this);
        this.handleClickSubmit = this.handleClickSubmit.bind(this);
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
                let data = {
                    'last_name' : $('#swal-input1').val(),
                    'phone' : $('#swal-input2').val(),
                    'address' : $('#swal-input3').val()
                };
                return axios
                    .post("/admin/customers", data)
                    .then((res) => {
                        Swal.fire({
                            icon: 'success',
                            title: `Tạo khách hàng thành công`,
                            showConfirmButton: false,
                            timer: 1500
                          })
                    })
                    .catch((err) => {
                        Swal.showValidationMessage(err.response.data.message);
                    })
            },
            allowOutsideClick: () => !Swal.isLoading(),
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
        this.setState({discount: parseFloat(discount)});
    }
    getTotal(cart) {
        let total = sum(cart.map((c) => c.pivot.quantity * c.outputprice));
        // this.setState({total: parseFloat(total)});
        return total;
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
                    this.loadCart();
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
            inputValue: this.state.totalBill,
            showCancelButton: true,
            cancelButtonText: "Hủy",
            confirmButtonText: "Tạo",
            showLoaderOnConfirm: true,
            preConfirm: (amount) => {
                return axios
                    .post("/admin/orders", {
                        customer_id: this.state.customer_id,
                        discount: this.state.discount,
                        amount,
                        
                    })
                    .then((res) => {
                        const divToPrint=document.getElementById("printTable");
                        const    newWin=  window.open("", "PrintWindow", "width=800,height=600");
                            newWin.document.write(divToPrint.outerHTML);
                            newWin.print();
                            newWin.close();
                        // this.loadCart();
                        // return res.data;
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
    componentDidUpdate(prevProps, prevState) {
        // Kiểm tra nếu giỏ hàng, giảm giá, hoặc giá sản phẩm thay đổi
        if (
          prevState.cart !== this.state.cart ||
          prevState.discount !== this.state.discount ||
          prevState.products !== this.state.products
        ) {
          this.calculateTotalBill();
        }
      }
      calculateTotalBill = () =>{
        let total = sum(this.state.cart.map((c) => c.pivot.quantity * c.outputprice));
        let totalBill = total - this.state.discount;
        totalBill = totalBill>0? totalBill: 0;
        this.setState({
            total: total,
            totalBill: totalBill
        });
      }
    render() {
        const { cart, products, customers, barcode } = this.state;
        return (
            <div className="row">
                <div class="d-none" id="printTable">
                    <div>
                        <div>
                            <div>
                                <table class="table table-striped "  width="100%">
                                    <tbody>
                                    <thead>
                                            <th width="80%"></th>
                                            <th width="20%"></th>
                                        </thead>
                                        <tr>
                                            <td><h1> Cửa hàng Thân Nguyệt</h1></td>
                                        </tr>
                                        <tr>
                                            <td><h2>ĐC:Ql48B, Quỳnh Châu, Quỳnh Lưu, NA </h2></td>
                                            <td><h1>HÓA ĐƠN BÁN HÀNG</h1></td>
                                        </tr>
                                        <tr>
                                            <td><h2>SĐT:0329790031-09664726629-0988690507</h2></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div width="100%">_________________________________________________________________________________________________________________________________
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <table class="table table-striped "  width="100%">
                                        <thead>
                                            <th width="70%"></th>
                                            <th width="30%"></th>
                                        </thead>
                                        <tbody>
                                            <tr>                                        
                                                <td><h1>{customers.last_name}</h1></td>                                         
                                                <td class="d-flex justify-content-end"> <h2>No:/</h2></td>
                                            </tr>
                                            <tr>
                                                <td><h2>ĐC:</h2></td>
                                            </tr>
                                            <tr>
                                                <td><h2>SĐT:</h2></td>
                                                <td class="d-flex justify-content-end"> <h2></h2></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="">
                                <table class="table table-striped" width="100%"  cellpadding="5">
                                    <thead>
                                        <tr class="">
                                            <td width="39%"><h2>Sản phẩm</h2></td>
                                            <th width="10%"><h2>Đơn vị</h2></th>
                                            <th width="13%"><h2>Số lượng</h2></th>
                                            <th width="23%"><h2>Giá bán</h2></th>
                                            <td><h2>Thành tiền</h2></td>
                                        </tr>
                                        <div width="100%">
                                _________________________________________________________________________________________________________________________________
                                </div>
                                    </thead>
                                    <tbody>
                                    {cart.map((c) => (
                                        <tr key={c.id} class="" text-align="center">
                                            <td class="d-flex justify-content-begin overflow-hidden"><h2>{c.name}</h2></td>
                                            <th class=""><h2>{c.description}</h2></th>
                                            <th class=""><h2>{c.pivot.quantity}</h2></th>
                                            <th class=""><h2>{c.outputprice}{window.APP.currency_symbol}</h2></th>
                                            <td class="d-flex justify-content-end"><h2>{c.pivot.quantity*c.outputprice}{window.APP.currency_symbol}</h2></td>
                                        </tr> 
                                    ))}
                                    </tbody>
                                </table>
                                <div width="100%">_________________________________________________________________________________________________________________________________</div>
                                <table class="table table-striped "  width="100%" >
                                    <thead>
                                        <tr>
                                            <th width="70%"></th>
                                            <th width="15%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="">
                                            <td class=""></td>
                                            <td class=""><h2>Tổng tiền:</h2></td>
                                            <td class="d-flex justify-content-end"><h2>{this.state.total}{window.APP.currency_symbol} </h2></td>
                                        </tr>
                                        <tr class="">
                                            <td class=""></td>
                                            <td class=""><h2>Chiết khấu:</h2></td>
                                            <td class="d-flex justify-content-end"><h2>{this.state.discount}{window.APP.currency_symbol} </h2></td>
                                        </tr>
                                    
                                        <tr class="">
                                            <td class=""></td>
                                            <td class=""><h2>Thành tiền:</h2></td>
                                            <td class="d-flex justify-content-end"><h2>{this.state.totalBill}{window.APP.currency_symbol} </h2></td>
                                        </tr>
                                        <tr class="">
                                            <td class=""></td>
                                            <td class=""><h2>Đã trả:</h2></td>
                                            <td class="d-flex justify-content-end"><h2>{window.APP.currency_symbol}</h2></td>
                                        </tr>
                                        <tr class="">
                                            <td class=""></td>
                                            <td class=""><h2>Dư nợ:</h2></td>
                                            <td class="d-flex justify-content-end"><h2></h2></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table>
                                    <thead>
                                        <tr>
                                            <th width="25%"><h2>khách hàng</h2></th>
                                            <th width="52%"></th>
                                            <th><h2>Người lập hóa đơn</h2></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <th>.</th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <th>.</th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                        <th><h3>{this.state.last_name}</h3></th>
                                        <td></td>
                                        <th><h3></h3></th>
                                        </tr>
                                    </tbody>
                                </table>
                                <div width="100%">_________________________________________________________________________________________________________________________________</div>
                                <table>
                                    <thead>
                                        <tr>
                                            <th width="100%"><h2>Cảm ơn quý khách hàng đã mua hàng.</h2></th>
                                        </tr>
                                        <tr>
                                            <th width="100%"><h2>Lưu ý: Chỉ được đổi tra khi hàng hóa còn nguyên vẹn và có hóa đơn! Xin cảm ơn.</h2></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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
                                <option value="">Khách lẻ</option>
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
                            {this.state.total}  {window.APP.currency_symbol}
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
                             {this.state.totalBill} {window.APP.currency_symbol}
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
                                            <span class="badge bg-label-primary me-1">{p.quantity} {p.unit_purchas}</span>
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