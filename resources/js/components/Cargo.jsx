import React, { Component } from "react";
import ReactDOM from "react-dom";
import axios from "axios";
import Swal from "sweetalert2";
import { sum } from "lodash";

class Cargo extends Component {
    constructor(props) {
        super(props);
        this.state = {
            cargo: [],
            products: [],
            suppliers: [],
            barcode: "",
            discount: 0,
            search: "",
            supplier_id: "",
            total: 0,
            totalBill: 0
        };

        this.loadPurcha = this.loadPurcha.bind(this);
        this.handleOnChangeBarcode = this.handleOnChangeBarcode.bind(this);
        this.handleScanBarcode = this.handleScanBarcode.bind(this);
        this.handleOnChangeDisscount = this.handleOnChangeDisscount.bind(this);
        this.handleChangeQty = this.handleChangeQty.bind(this);
        this.handleEmptyPurcha = this.handleEmptyPurcha.bind(this);

        this.loadProducts = this.loadProducts.bind(this);
        this.handleChangeSearch = this.handleChangeSearch.bind(this);
        this.handleSeach = this.handleSeach.bind(this);
        this.setSupplierId = this.setSupplierId.bind(this);
        this.handleClickSubmit = this.handleClickSubmit.bind(this);
    }

    componentDidMount() {
        // load user cargo
        this.loadPurcha();
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

    loadPurcha() {
        axios.get("/admin/cargo").then((res) => {
            const cargo = res.data;
            this.setState({ cargo });
        });
    }

    handleScanBarcode(event) {
        event.preventDefault();
        const { barcode } = this.state;
        if (!!barcode) {
            axios
                .post("/admin/cargo", { barcode })
                .then((res) => {
                    this.loadPurcha();
                    this.setState({ barcode: "" });
                })
                .catch((err) => {
                    Swal.fire("Lỗi!", err.response.data.message, "error");
                });
        }
    }
    handleChangeQty(product_id, qty) {
        const cargo = this.state.cargo.map((c) => {
            if (c.id === product_id) {
                c.pivot.quantity = qty;
            }
            return c;
        });

        this.setState({ cargo });
        if (!qty) return;

        axios
            .post("/admin/cargo/change-qty", { product_id, quantity: qty })
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
    getTotal(cargo) {
        let total = sum(cargo.map((c) => c.pivot.quantity * c.inputprice));
        // this.setState({total: parseFloat(total)});
        return total;
    }
    handleClickDelete(product_id) {
        axios
            .post("/admin/cargo/delete", { product_id, _method: "DELETE" })
            .then((res) => {
                const cargo = this.state.cargo.filter((c) => c.id !== product_id);
                this.setState({ cargo });
            });
    }
    handleEmptyPurcha() {
        axios.post("/admin/cargo/empty", { _method: "DELETE" }).then((res) => {
            this.setState({ cargo: [] });
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

    addProductToPurcha(barcode) {
        let product = this.state.products.find((p) => p.barcode === barcode);
        if (!!product) {
            // if product is already in cargo
            let cargo = this.state.cargo.find((c) => c.id === product.id);
            if (!!cargo) {
                // update quantity
                this.setState({
                    cargo: this.state.cargo.map((c) => {
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

                    this.setState({ cargo: [...this.state.cargo, product] });
                }
            }
            
            axios
                .post("/admin/cargo", { barcode })
                .then((res) => {
                    this.loadPurcha();
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
            title: "Lưu đơn nhập hàng",
            html:'<p>Số tiền đã hanh toán</p>',
            input: "text",
            inputValue: this.state.totalBill,
            showCancelButton: true,
            cancelButtonText: "Hủy",
            confirmButtonText: "Lưu",
            showLoaderOnConfirm: true,
            preConfirm: (amount) => {
                return axios
                    .post("/admin/purchars", {
                        supplier_id: this.state.supplier_id,
                        discount: this.state.discount,
                        amount,
                        
                    })
                    .then((res) => {
                        this.loadPurcha();
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
          prevState.cargo !== this.state.cargo ||
          prevState.discount !== this.state.discount ||
          prevState.products !== this.state.products
        ) {
          this.calculateTotalBill();
        }
      }
      calculateTotalBill = () =>{
        let total = sum(this.state.cargo.map((c) => c.pivot.quantity * c.outputprice));
        let totalBill = total - this.state.discount;
        totalBill = totalBill>0? totalBill: 0;
        this.setState({
            total: total,
            totalBill: totalBill
        });
      }
    render() {
        const { cargo, products, suppliers, barcode } = this.state;
        return (
            <div className="row">
                <div className="col-md-9 col-lg-8">
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
                                <option value="">Nhà phân phối</option>
                                {suppliers.map((sup) => (
                                    <option
                                        key={sup.id}
                                        value={sup.id}
                                    >{`${sup.name}`}</option>
                                ))}
                            </select>
                        </div>

                    </div>
                    <div className="user-purcha mb-1">
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
                                    {cargo.map((c) => (
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
                                                    c.inputprice * c.pivot.quantity
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
                                onClick={this.handleEmptyPurcha}
                                disabled={!cargo.length}
                            >
                                Hủy
                            </button>
                        </div>
                        <div className="col d-flex align-items-center justify-content-end">
                            <button
                                type="button"
                                className="btn btn-primary btn-block"
                                disabled={!cargo.length}
                                onClick={this.handleClickSubmit}
                            >
                                Lưu
                            </button>
                        </div>
                    </div>
                </div>
                <div className="col-md-3 col-lg-4">
                    <div className="mb-2">
                        <input
                            type="text"
                            className="form-control"
                            placeholder="Tìm kiếm sản phẩm..."
                            onChange={this.handleChangeSearch}
                            onKeyDown={this.handleSeach}
                        />
                    </div>
                    <div className="order-product">
                        <div className="row">
                           
                        <div class="col-md-12 d-flex flex-row flex-wrap bd-highlight list-item mt-2 overflow-auto vh-100">
                            {products.map((p) => (
                                <div class="col-xl-6 col-md-4 col-6 p-1">
                            <div onClick={() => this.addProductToPurcha(p.barcode)}
                            key={p.id} class="card overflow-hidden bd-highlight">
                                <div class="list-thumb d-flex  justify-content-center">
                                    <img src={p.image_url} height="100px" width="100%"/>
                                </div> 
                                <div class="flex-grow-1 d-bock">
                                    <div class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center">
                                        <div class="w-40 w-sm-100 item-title ct-inline">{p.name}</div> 
                                        <p class="text-muted text-black-50 w-15 w-sm-100 mb-1">{p.barcode}</p>
                                        <span class=" w-sm-100">{p.inputprice}{window.APP.currency_symbol}</span>  
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

export default Cargo;

if (document.getElementById("cargo")) {
    ReactDOM.render(<Cargo />, document.getElementById("cargo"));
}