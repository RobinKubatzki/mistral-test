FROM mysql:8.0

# Set environment variables
ENV MYSQL_ROOT_PASSWORD=root_password
ENV MYSQL_DATABASE=checkin_tool
ENV MYSQL_USER=checkin_user
ENV MYSQL_PASSWORD=checkin_password

# Copy initialization script
COPY init.sql /docker-entrypoint-initdb.d/

# Expose port
EXPOSE 3306

# Start MySQL
CMD ["mysqld"]
