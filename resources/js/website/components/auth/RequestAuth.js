import { Navigate } from "react-router-dom";
import { useAuth } from "./Auth";

export const RequestAuth = ({ children }) => {
    const auth = useAuth()

    if (!auth.user) {
        return <Navigate to="/login"/>
    }

    return children;
}