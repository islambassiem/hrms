import { Head } from '@inertiajs/react';
import { EmployeeLandingDashboard } from '@/components/employee-landing-dashboard';
import { dashboard } from '@/routes';

export default function Dashboard() {
    return (
        <>
            <Head title="Employee dashboard" />
            <EmployeeLandingDashboard />
        </>
    );
}

Dashboard.layout = {
    breadcrumbs: [
        {
            title: 'Dashboard',
            href: dashboard(),
        },
    ],
};
