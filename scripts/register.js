function RegisterForm() {
    const [name, setName] = React.useState("");
    const [phone, setPhone] = React.useState("");
    const [email, setEmail] = React.useState("");
    const [password, setPassword] = React.useState("");
    const [message, setMessage] = React.useState("");
    const [loading, setLoading] = React.useState(false);

    function submitForm() {

        // ========================
        // CLIENT-SIDE VALIDATION
        // ========================
        if (!name || !phone || !email || !password) {
            setMessage("All fields are required");
            return;
        }

        if (!/^[A-Za-z ]+$/.test(name)) {
            setMessage("Name must contain only letters");
            return;
        }

        if (!/^[0-9]{10}$/.test(phone)) {
            setMessage("Phone must be 10 digits");
            return;
        }

        if (!email.includes("@")) {
            setMessage("Invalid email address");
            return;
        }

        // ========================
        // API CALL
        // ========================
        setLoading(true);

        fetch("api/register_api.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                name,
                phone,
                email,
                password
            })
        })
        .then(res => {
            if (!res.ok) throw new Error("Network error");
            return res.json();
        })
        .then(data => {
            setMessage(data.message);

            if (data.status === "success") {
                setTimeout(() => {
                    window.location.href = "login.php";
                }, 1500);
            }

            // Optional: handle email already exists cleanly
            if (data.error_type === "email_exists") {
                setMessage("This email is already registered");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            setMessage("Something went wrong. Please try again.");
        })
        .finally(() => {
            setLoading(false);
        });
    }

    return (
        <div>

            {/* MESSAGE DISPLAY */}
            {message && (
                <p className="message">
                    {message}
                </p>
            )}

            {/* NAME */}
            <input
                name="Name"
                placeholder="Name"
                value={name}
                onChange={(e) => setName(e.target.value)}
            />
            {name && !/^[A-Za-z ]+$/.test(name) && (
                <p style={{ color: "red" }}>Only letters allowed</p>
            )}

            <br />

            {/* PHONE */}
            <input
                name="Phone"
                placeholder="Phone"
                value={phone}
                onChange={(e) => setPhone(e.target.value)}
            />
            {phone && !/^[0-9]{10}$/.test(phone) && (
                <p style={{ color: "red" }}>10 digit number required</p>
            )}

            <br />

            {/* EMAIL */}
            <input
                name="Email"
                placeholder="Email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
            />
            {email && !email.includes("@") && (
                <p style={{ color: "red" }}>Invalid email</p>
            )}

            <br />

            {/* PASSWORD */}
            <input
                name="Password"
                type="password"
                placeholder="Password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
            />

            <br /><br />

            {/* LOGIN LINK */}
            <p>
                Already have an account? <a href="login.php">Login here</a>
            </p>

            <br /><br />

            {/* SUBMIT BUTTON */}
            <button
                onClick={submitForm}
                disabled={
                    loading ||
                    !name ||
                    !phone ||
                    !email ||
                    !password ||
                    !/^[A-Za-z ]+$/.test(name) ||
                    !/^[0-9]{10}$/.test(phone) ||
                    !email.includes("@")
                }
            >
                {loading ? "Registering..." : "Register"}
            </button>

        </div>
    );
}

ReactDOM.createRoot(document.getElementById("root"))
    .render(<RegisterForm />);