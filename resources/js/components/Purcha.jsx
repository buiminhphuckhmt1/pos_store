import React, { Component } from "react";
import ReactDOM from "react-dom";
import axios from "axios";
import Swal from "sweetalert2";
import { sum } from "lodash";

class Purcha extends Component {
    constructor(props) {
        super(props);
        this.state = {
            purcha: [],
            products: [],
            suppliers: [],
            barcode: "",
            discount: 0,
            search: "",
            supplier_id: "",
            total: 0,
            totalBill: 0
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
        this.setSupplierId = this.setSupplierId.bind(this);
        this.handleClickSubmit = this.handleClickSubmit.bind(this);
    }

    componentDidMount() {
        // load user purcha
        this.loadCart();
        this.loadProducts();
        this.loadSuppliers();
    }

    loadSuppliers() {
        axios.get(`/admin/suppliers`).then((res) => {
            const suppliers = res.data;
            this.setState({ suppliers });
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
        axios.get("/admin/purcha").then((res) => {
            const purcha = res.data;
            this.setState({ purcha });
        });
    }

    handleScanBarcode(event) {
        event.preventDefault();
        const { barcode } = this.state;
        if (!!barcode) {
            axios
                .post("/admin/purcha", { barcode })
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
        const purcha = this.state.purcha.map((c) => {
            if (c.id === product_id) {
                c.pivot.quantity = qty;
            }
            return c;
        });

        this.setState({ purcha });
        if (!qty) return;

        axios
            .post("/admin/purcha/change-qty", { product_id, quantity: qty })
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
    getTotal(purcha) {
        let total = sum(purcha.map((c) => c.pivot.quantity * c.outputprice));
        // this.setState({total: parseFloat(total)});
        return total;
    }
    handleClickDelete(product_id) {
        axios
            .post("/admin/purcha/delete", { product_id, _method: "DELETE" })
            .then((res) => {
                const purcha = this.state.purcha.filter((c) => c.id !== product_id);
                this.setState({ purcha });
            });
    }
    handleEmptyCart() {
        axios.post("/admin/purcha/empty", { _method: "DELETE" }).then((res) => {
            this.setState({ purcha: [] });
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
            // if product is already in purcha
            let purcha = this.state.purcha.find((c) => c.id === product.id);
            if (!!purcha) {
                // update quantity
                this.setState({
                    purcha: this.state.purcha.map((c) => {
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

                    this.setState({ purcha: [...this.state.purcha, product] });
                }
            }
            
            axios
                .post("/admin/purcha", { barcode })
                .then((res) => {
                    // this.loadCart();
                    console.log(res);
                })
                .catch((err) => {
                    Swal.fire("Error!", err.response.data.message, "error");
                });
        }
    }

    setSupplierId(event) {
        this.setState({ supplier_id: event.target.value });
    }
    handleClickSubmit() {
        Swal.fire({
            title: "Lưu",
            html:'<p>Số đã thanh toán được</p>',
            input: "text",
            inputValue: this.state.totalBill,
            showCancelButton: true,
            cancelButtonText: "Hủy",
            confirmButtonText: "Lưu",
            showLoaderOnConfirm: true,
            preConfirm: (amount) => {
                return axios
                    .post("/admin/purchas", {
                        supplier_id: this.state.supplier_id,
                        discount: this.state.discount,
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
    componentDidUpdate(prevProps, prevState) {
        // Kiểm tra nếu giỏ hàng, giảm giá, hoặc giá sản phẩm thay đổi
        if (
          prevState.purcha !== this.state.purcha ||
          prevState.discount !== this.state.discount ||
          prevState.products !== this.state.products
        ) {
          this.calculateTotalBill();
        }
      }
      calculateTotalBill = () =>{
        let total = sum(this.state.purcha.map((c) => c.pivot.quantity * c.outputprice));
        let totalBill = total - this.state.discount;
        totalBill = totalBill>0? totalBill: 0;
        this.setState({
            total: total,
            totalBill: totalBill
        });
      }
    render() {
        const { purcha, products, suppliers, barcode } = this.state;
        return (
            <div className="row">
                <div className="col-md-12 col-lg-12">
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
                                onChange={this.setSupplierId}
                            >
                                <option value="">Chọn nhà phân phối</option>
                                {suppliers.map((cus) => (
                                    <option
                                        key={cus.id}
                                        value={cus.id}
                                    >{`${cus.name}`}</option>
                                ))}
                            </select>
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
                                    {purcha.map((c) => (
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
                                disabled={!purcha.length}
                            >
                                Hủy
                            </button>
                        </div>
                        <div className="col d-flex align-items-center justify-content-end">
                            <button
                                type="button"
                                className="btn btn-primary btn-block"
                                disabled={!purcha.length}
                                onClick={this.handleClickSubmit}
                            >
                                Lưu
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default Purcha;

if (document.getElementById("purcha")) {
    ReactDOM.render(<Purcha />, document.getElementById("purcha"));
}

