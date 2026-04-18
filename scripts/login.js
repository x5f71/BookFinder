function LoginForm() {

    const [email, setEmail] = React.useState("");
    const [password, setPassword] = React.useState("");
    const [captcha, setCaptcha] = React.useState("");
    const [captchaImg, setCaptchaImg] = React.useState("");
    const [message, setMessage] = React.useState("");
    const [loading, setLoading] = React.useState(false);

    // load captcha on page load
    React.useEffect(() => {
        loadCaptcha();
    }, []);

    function loadCaptcha() {
        fetch("api/get_captcha.php")
            .then(res => res.json())
            .then(data => {
                setCaptchaImg(data.image);
            })
            .catch(() => {
                setMessage("Failed to load CAPTCHA");
            });
    }

    function submitLogin() {

        if (!email || !password || !captcha) {
            setMessage("All fields required");
            return;
        }

        setLoading(true);

        fetch("api/login_api.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                email,
                password,
                captcha
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
                    window.location.href = "index.php";
                }, 1000);
            } else {
                // refresh captcha on failure
                loadCaptcha();
                setCaptcha("");
            }
        })
        .catch(() => {
            setMessage("Something went wrong. Please try again.");
            loadCaptcha();
        })
        .finally(() => {
            setLoading(false);
        });
    }

    return (
        <div>

            {message && <p className="message">{message}</p>}

            <input
                placeholder="Email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
            />

            <br />

            <input
                type="password"
                placeholder="Password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
            />

            <br />

            {/* CAPTCHA IMAGE */}
            {captchaImg && (
                <img
                    className="captcha-image"
                    src={captchaImg}
                    alt="captcha"
                    onClick={loadCaptcha}
                    style={{ cursor: "pointer" }}
                    title="Click to refresh CAPTCHA"
                />
            )}

            <br />

            <input
                placeholder="Enter CAPTCHA"
                value={captcha}
                onChange={(e) => setCaptcha(e.target.value)}
            />

            <br /><br />

            <button onClick={submitLogin} disabled={loading}>
                {loading ? "Logging in..." : "Login"}
            </button>

            <br /><br />

            <p>
                Not registered yet? <a href="register.php">Register here</a>
            </p>

        </div>
    );
}

ReactDOM.createRoot(document.getElementById("root"))
    .render(<LoginForm />);